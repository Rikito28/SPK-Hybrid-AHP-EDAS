<?php
include('config.php');
//-- inisialisasi variabel array matriks keputusan X
$X = array();
//-- ambil nilai dari tabel
$sql = 'SELECT id_alternatif, id_kriteria, value FROM matriks';
$data = $koneksi->query($sql);
while ($row = $data->fetch_object()) {
    $i = $row->id_alternatif;
    $j = $row->id_kriteria;
    $aij = $row->value;
    $X[$i][$j] = $aij;
}

$jml_alternative = count($X); // Jumlah alternatif

//-- inisialisasi array solusi rata-rata (AV)
$AV = array();
foreach ($X as $i => $ai) {
    foreach ($ai as $j => $aij) {
        if (!isset($AV[$j])) {
            $AV[$j] = 0;
        }
        $AV[$j] += $aij / $jml_alternative;
    }
}
?>