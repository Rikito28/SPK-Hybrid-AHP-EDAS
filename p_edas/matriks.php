<?php 
	include('../config.php');
	include('../fungsi.php');
    include('header.php');

?>

<section class="content">

	<h1 class="ui header">Matriks Keputusan</h1>
		<tbody>
        <?php
            $query1 = "SELECT nama FROM alternatif ORDER BY id_alternatif";
            $result1 = mysqli_query($koneksi, $query1);
            if (!$result1) {
                die("Query error: " . mysqli_error($koneksi));
            }

            $i = 0;
            $alternatifNames = array();
            while ($row = mysqli_fetch_array($result1)) {
                $i++;
                $alternatifNames[$i] = $row['nama'];
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

            <!-- Tabel Matriks -->
            <table class="ui celled red table">
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
                    <?php
                    foreach ($matriks as $alternatifId => $kriteria) {
                        ?>
                        <tr>
                            <td><?php echo $alternatifId; ?></td>
                            <td><?php echo $alternatifNames[$alternatifId]; ?></td>
                            <?php foreach ($kriteriaIds as $kriteriaId) { ?>
                                <td><?php echo $kriteria[$kriteriaId]; ?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>


    <!-- Tabel Bobot -->
    <h2 class="ui header">Bobot Kriteria</h2>
    
    <table class="ui celled red table">
        <thead>
            <tr>
                <?php
                    // Mendapatkan Id kriteria dari database
                    $query = "SELECT id_kriteria FROM kriteria_edas ORDER BY id_kriteria";
                    $result = mysqli_query($koneksi, $query);

                    while ($row = mysqli_fetch_array($result)) {
                ?>
                    <th><?php echo "C" . $row['id_kriteria']; ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                    // Mendapatkan bobot kriteria dari database
                    $query = "SELECT bobot FROM kriteria_edas ORDER BY id_kriteria";
                    $result = mysqli_query($koneksi, $query);

                    while ($row = mysqli_fetch_array($result)) {
                ?>
                    <td><?php echo number_format($row['bobot'],3); ?></td>
                <?php } ?>
            </tr>
        </tbody>
    </table>

    <!-- Nilai Solusi Rata Rata -->
    <h2 class="ui header">Nilai Solusi Rata-rata(AV)</h2>
        <table class="ui celled red table">
            <thead>
                <tr>
                    <?php foreach ($kriteriaIds as $kriteriaId) { ?>
                        <th><?php echo "C" . $kriteriaId; ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php foreach ($kriteriaIds as $kriteriaId) { ?>
                        <?php
                        $queryMatriks = "SELECT value FROM matriks WHERE id_kriteria = ?";
                        $statement = mysqli_prepare($koneksi, $queryMatriks);
                        mysqli_stmt_bind_param($statement, "i", $kriteriaId);
                        mysqli_stmt_execute($statement);
                        $resultMatriks = mysqli_stmt_get_result($statement);

                        $totalNilai = 0;
                        $totalAlternatif = count($alternatifNames);
                        while ($row = mysqli_fetch_array($resultMatriks)) {
                            $totalNilai += $row['value'];
                        }

                        $rataRata = $totalNilai / $totalAlternatif;

                        // Update nilai rata-rata ke dalam kolom av di tabel matriks
                        $queryUpdateRataRata = "UPDATE kriteria_edas SET av = ? WHERE id_kriteria = ?";
                        $statementUpdate = mysqli_prepare($koneksi, $queryUpdateRataRata);
                        mysqli_stmt_bind_param($statementUpdate, "di", $rataRata, $kriteriaId);
                        mysqli_stmt_execute($statementUpdate);
                        ?>
                        <td><?php echo number_format($rataRata, 3); ?></td>
                    <?php } ?>
                </tr>
            </tbody>
    </table>


    <br><br>

	<form action="pda.php">
	<button class="ui right labeled icon button" style="float: right;">
		<i class="right arrow icon"></i>
		Lanjut
	</button>
	</form>
</section>

<?php include('../footer.php'); ?>