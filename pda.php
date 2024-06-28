<?php
include('config.php');
include('fungsi.php');
include('header.php');

        $xij = array(); // Inisialisasi variabel $xij sebagai array

        $sqlXij = 'SELECT id_alternatif, id_kriteria, value FROM matriks';
        $resultXij = mysqli_query($koneksi, $sqlXij);

        if (!$resultXij) {
            die("Query error: " . mysqli_error($koneksi));
        }

        while ($rowXij = mysqli_fetch_assoc($resultXij)) {
            $id_alternatif = $rowXij['id_alternatif'];
            $id_kriteria = $rowXij['id_kriteria'];
            $value = $rowXij['value'];
            $xij[$id_alternatif][$id_kriteria] = floatval($value);
        }

        // Mengambil bobot dari tabel kriteria_edas
        $w = array(); // Inisialisasi variabel w sebagai array
        $sqlBobot = 'SELECT bobot FROM kriteria_edas';
        $resultBobot = mysqli_query($koneksi, $sqlBobot);

        if (!$resultBobot) {
            die("Query error: " . mysqli_error($koneksi));
        }

        while ($rowBobot = mysqli_fetch_assoc($resultBobot)) {
            $w[] = floatval($rowBobot['bobot']); // Menambahkan nilai bobot ke array w
        }

        // Ambil nilai alternatif pada tabel alternatif
        $alternatif = array();

            $query = "SELECT name FROM alternatif";
            $result = mysqli_query($koneksi, $query);

            if (!$result) {
                die("Query error: " . mysqli_error($koneksi));
            }

            while ($row = mysqli_fetch_assoc($result)) {
                $alternatif[] = $row['name'];
        }

        // Ambil nilai kolom av dari tabel matriks dan isi variabel AV
        $AV = array(); // Inisialisasi variabel AV sebagai array

        $sqlAV = 'SELECT av FROM matriks';
        $resultAV = mysqli_query($koneksi, $sqlAV);

        if (!$resultAV) {
            die("Query error: " . mysqli_error($koneksi));
        }

        while ($rowAV = mysqli_fetch_assoc($resultAV)) {
            $AV[] = floatval($rowAV['av']); // Konversi nilai menjadi tipe data float dan tambahkan ke array $AV
        }

        // Pengambilan data kriteria
        $kriteria = array(); // Inisialisasi variabel kriteria sebagai array

        $sqlKriteria = 'SELECT * FROM kriteria_edas';
        $resultKriteria = mysqli_query($koneksi, $sqlKriteria);

        if (!$resultKriteria) {
            die("Query error: " . mysqli_error($koneksi));
        }

        while ($rowKriteria = mysqli_fetch_assoc($resultKriteria)) {
            $kriteriaId = $rowKriteria['id_kriteria'];
            $kriteria[$kriteriaId] = array(
                $rowKriteria['kriteria'],
                $rowKriteria['atribut']
            );
        }

        // Perhitungan PDA
        $PDA = array();
        $NDA = array();
        foreach ($xij as $i => $xi) {
            $PDA[$i] = array();
            foreach ($xi as $j => $xijValue) {
                if ($kriteria[$j][1] == 'benefit') {
                    $PDA[$i][$j] = max(0, ($xijValue - $AV[$j - 1]) / $AV[$j - 1]);
                } else {
                    $PDA[$i][$j] = max(0, ($AV[$j - 1] - $xijValue) / $AV[$j - 1]);
                }
            }
        }

        // Simpan nilai PDA ke dalam kolom 'pda' pada tabel 'matriks'
        foreach ($PDA as $alternatifId => $kriteriaPDA) {
            foreach ($kriteriaPDA as $kriteriaId => $nilaiPDA) {
                $sqlUpdate = "UPDATE matriks SET pda = $nilaiPDA WHERE id_alternatif = $alternatifId AND id_kriteria = $kriteriaId";
                $resultUpdate = mysqli_query($koneksi, $sqlUpdate);
                if (!$resultUpdate) {
                    die("Query error: " . mysqli_error($koneksi));
                }
            }
        }

        // Perhitungan NDA
        $NDA = array();
        foreach ($xij as $i => $xi) {
            $NDA[$i] = array();
            foreach ($xi as $j => $xijValue) {
                if ($kriteria[$j][1] == 'benefit') {
                    $NDA[$i][$j] = max(0, ($AV[$j - 1] - $xijValue) / $AV[$j - 1]);
                } else {
                    $NDA[$i][$j] = max(0, ($xijValue - $AV[$j - 1]) / $AV[$j - 1]);
                }
            }
        }

        // Simpan nilai NDA ke dalam kolom 'nda' pada tabel 'matriks'
        foreach ($NDA as $alternatifId => $kriteriaNDA) {
            foreach ($kriteriaNDA as $kriteriaId => $nilaiNDA) {
                $sqlUpdate = "UPDATE matriks SET nda = $nilaiNDA WHERE id_alternatif = $alternatifId AND id_kriteria = $kriteriaId";
                $resultUpdate = mysqli_query($koneksi, $sqlUpdate);
                if (!$resultUpdate) {
                    die("Query error: " . mysqli_error($koneksi));
                }
            }
        }

        // Menghitung Jumlah nilai Terbobot SP/SN
        // inisialisasi array SP & SN
        $SP= array();
        $SN= array();
        foreach($xij as $i=>$xi){
            $SP[$i]=0;
            $SN[$i]=0;
            foreach($xi as $j=>$xij){
                $SP[$i]+=$w[$j - 1]*$PDA[$i][$j];
                $SN[$i]+=$w[$j - 1]*$NDA[$i][$j]; 
            }
        }

        // Simpan nilai SP ke dalam kolom 'j_sp' pada tabel 'alternatif'
        foreach ($SP as $alternatifId => $jumlahSP) {
            $sqlUpdate = "UPDATE alternatif SET j_sp = $jumlahSP WHERE id_alternatif = $alternatifId";
            $resultUpdate = mysqli_query($koneksi, $sqlUpdate);
            if (!$resultUpdate) {
                die("Query error: " . mysqli_error($koneksi));
            }
        }

        // Simpan nilai SN ke dalam kolom 'j_sn' pada tabel 'alternatif'
        foreach ($SN as $alternatifId => $jumlahSN) {
            $sqlUpdate = "UPDATE alternatif SET j_sn = $jumlahSN WHERE id_alternatif = $alternatifId";
            $resultUpdate = mysqli_query($koneksi, $sqlUpdate);
            if (!$resultUpdate) {
                die("Query error: " . mysqli_error($koneksi));
            }
        }

        // Menghitung Nilai Normalisasi SP/SN

        $NSP=array();
        $NSN=array();
        foreach($alternatif as $i=> $Penilaian_edas)
        {
            $NSP[$i + 1]=$SP[$i + 1]/max($SP);
            $NSN[$i + 1]=1-$SN[$i + 1]/max($SN);
        }

        // Simpan nilai NSP ke dalam kolom 'nsp' pada tabel 'alternatif'
        foreach ($NSP as $alternatifId => $jumlahNSP) {
            $sqlUpdate = "UPDATE alternatif SET nsp = $jumlahNSP WHERE id_alternatif = $alternatifId";
            $resultUpdate = mysqli_query($koneksi, $sqlUpdate);
            if (!$resultUpdate) {
                die("Query error: " . mysqli_error($koneksi));
            }
        }

        // Simpan nilai NSN ke dalam kolom 'nsn' pada tabel 'alternatif'
        foreach ($NSN as $alternatifId => $jumlahNSN) {
            $sqlUpdate = "UPDATE alternatif SET nsn = $jumlahNSN WHERE id_alternatif = $alternatifId";
            $resultUpdate = mysqli_query($koneksi, $sqlUpdate);
            if (!$resultUpdate) {
                die("Query error: " . mysqli_error($koneksi));
            }
        }

        //-- inisialisasi nilai skor penilaian AS
            $AS=array();
            foreach($alternatif as $i=>$ax)
            {
                $AS[$i + 1]=($NSP[$i + 1]+$NSN[$i + 1])/2;
            } 

            // Simpan nilai NSN ke dalam kolom 'nsn' pada tabel 'alternatif'
        foreach ($AS as $alternatifId => $jumlahAS) {
            $sqlUpdate = "UPDATE alternatif SET q = $jumlahAS WHERE id_alternatif = $alternatifId";
            $resultUpdate = mysqli_query($koneksi, $sqlUpdate);
            if (!$resultUpdate) {
                die("Query error: " . mysqli_error($koneksi));
            }
        }

        //-- Perangkingan mengurutkan secara descending
        arsort($AS); 
        
        ?>

    <section class="content">

    <!-- Tabel PDA -->
    <h1 class="ui header">JARAK POSITIF/NEGATIF RATA-RATA (PDA)</h1>
    <table class="ui celled table">
    <?php
            $query1 = "SELECT name FROM alternatif ORDER BY id_alternatif";
            $result1 = mysqli_query($koneksi, $query1);
            if (!$result1) {
                die("Query error: " . mysqli_error($koneksi));
            }

            $i = 0;
            $alternatifNames = array();
            while ($row = mysqli_fetch_array($result1)) {
                $i++;
                $alternatifNames[$i] = $row['name'];
            }

            // Mendapatkan semua kriteria
            $queryKriteria = "SELECT id_kriteria FROM kriteria_edas";
            $resultKriteria = mysqli_query($koneksi, $queryKriteria);
            if (!$resultKriteria) {
                die("Query error: " . mysqli_error($koneksi));
            }

            $kriteriaIds = array();
            while ($row = mysqli_fetch_array($resultKriteria)) {
                $kriteriaIds[] = $row['id_kriteria'];
            }

            // Mendapatkan nilai matriks untuk setiap kriteria
            $matriks = array();
            foreach ($kriteriaIds as $kriteriaId) {
                $queryMatriks = "SELECT id_alternatif, value FROM matriks WHERE id_kriteria = $kriteriaId ORDER BY id_alternatif";
                $resultMatriks = mysqli_query($koneksi, $queryMatriks);
                if (!$resultMatriks) {
                    die("Query error: " . mysqli_error($koneksi));
                }

                while ($row = mysqli_fetch_array($resultMatriks)) {
                    $alternatifId = $row['id_alternatif'];
                    $matriks[$alternatifId][$kriteriaId] = $row['value'];
                }
            }
            ?>
        <thead>
            <tr>
                <th class="collapsing">No</th>
                <th colspan="1">Nama Alternatif</th>
                <?php foreach ($kriteriaIds as $kriteriaId) { ?>
                    <th><?php echo "C" . $kriteriaId; ?></th>
                    
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($PDA as $alternatifId => $kriteriaPDA) { ?>
                <tr>
                    <td><?php echo $alternatifId; ?></td>
                    <td><?php echo $alternatifNames[$alternatifId]; ?></td>
                    <?php foreach ($kriteriaPDA as $kriteriaId => $nilaiPDA) { ?>
                        <td><?php echo number_format($PDA[$alternatifId][$kriteriaId], 3); ?></td>
                        
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot class="full-width">
            <tr>
                <th colspan="<?php echo count($kriteriaIds) * 2 + 2; ?>">
                    <a href="tambah.php?jenis=alternatif">
                        <div class="ui right floated small primary labeled icon button">
                            <i class="plus icon"></i>Tambah
                        </div>
                    </a>
                </th>
            </tr>
        </tfoot>
    </table>

    <!-- Tabel NDA -->
    <h1 class="ui header">JARAK POSITIF/NEGATIF RATA-RATA (NDA)</h1>
    <table class="ui celled table">
    <?php
            $query1 = "SELECT name FROM alternatif ORDER BY id_alternatif";
            $result1 = mysqli_query($koneksi, $query1);
            if (!$result1) {
                die("Query error: " . mysqli_error($koneksi));
            }

            $i = 0;
            $alternatifNames = array();
            while ($row = mysqli_fetch_array($result1)) {
                $i++;
                $alternatifNames[$i] = $row['name'];
            }

            // Mendapatkan semua kriteria
            $queryKriteria = "SELECT id_kriteria FROM kriteria_edas";
            $resultKriteria = mysqli_query($koneksi, $queryKriteria);
            if (!$resultKriteria) {
                die("Query error: " . mysqli_error($koneksi));
            }

            $kriteriaIds = array();
            while ($row = mysqli_fetch_array($resultKriteria)) {
                $kriteriaIds[] = $row['id_kriteria'];
            }

            // Mendapatkan nilai matriks untuk setiap kriteria
            $matriks = array();
            foreach ($kriteriaIds as $kriteriaId) {
                $queryMatriks = "SELECT id_alternatif, value FROM matriks WHERE id_kriteria = $kriteriaId ORDER BY id_alternatif";
                $resultMatriks = mysqli_query($koneksi, $queryMatriks);
                if (!$resultMatriks) {
                    die("Query error: " . mysqli_error($koneksi));
                }

                while ($row = mysqli_fetch_array($resultMatriks)) {
                    $alternatifId = $row['id_alternatif'];
                    $matriks[$alternatifId][$kriteriaId] = $row['value'];
                }
            }
            ?>
        <thead>
            <tr>
                <th class="collapsing">No</th>
                <th colspan="1">Nama Alternatif</th>
                <?php foreach ($kriteriaIds as $kriteriaId) { ?>
                    <th><?php echo "C" . $kriteriaId; ?></th>
                    
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($NDA as $alternatifId => $kriteriaNDA) { ?>
                <tr>
                    <td><?php echo $alternatifId; ?></td>
                    <td><?php echo $alternatifNames[$alternatifId]; ?></td>
                    <?php foreach ($kriteriaNDA as $kriteriaId => $nilaiNDA) { ?>
                        <td><?php echo number_format($NDA[$alternatifId][$kriteriaId], 3); ?></td>
                        
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot class="full-width">
            <tr>
                <th colspan="<?php echo count($kriteriaIds) * 2 + 2; ?>">
                    <a href="tambah.php?jenis=alternatif">
                        <div class="ui right floated small primary labeled icon button">
                            <i class="plus icon"></i>Tambah
                        </div>
                    </a>
                </th>
            </tr>
        </tfoot>
    </table>

</section>

<?php include('footer.php'); ?>