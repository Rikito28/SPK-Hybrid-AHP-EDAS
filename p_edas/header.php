<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Sistem Pendukung Keputusan metode EDAS</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../semantic/dist/semantic.min.css">
</head>

<body>
<header>
	<h1>Sistem Pendukung Keputusan dengan metode EDAS</h1>
</header>

<div class="wrapper">
	<nav id="navigation" role="navigation">
		<ul>
			<li><a class="item" href="index.php">Home</a></li>
			<li>
				<a class="item" href="kriteria.php">Kriteria
					<div class="ui blue tiny label" style="float: right;"><?php echo getJumlahKriteria(); ?></div>
				</a>
			</li>
			<li>
				<a class="item" href="alternatif.php">Alternatif
					<div class="ui blue tiny label" style="float: right;"><?php echo getJumlahAlternatif(); ?></div>
				</a>
			</li>
			<li>
				<a class="item" href="matriks.php">Matriks Keputusan
					<div class="ui blue tiny label" style="float: right;"><?php echo getJumlahMatriks(); ?></div>
				</a>
			</li>
			<li>
				<a class="item" href="pda.php">Perhitungan Jarak Positif/Negatif (PDA/NDA)
					<div class="ui blue tiny label" style="float: right;"><?php echo getJumlahPDA(); ?></div>
				</a>
			</li>
			<li>
				<a class="item" href="nilai_sp.php">Menentukan Jumlah Nilai Terbobot
					<div class="ui blue tiny label" style="float: right;"><?php echo getJumlahSP(); ?></div>
				</a>
			</li>
			<li>
				<a class="item" href="nilai_akhir_edas.php">Nilai Akhir dan Perankingan</a>
			</li>
			<li>
				<a class="item" href="../index.php">Kembali</a>
			</li>
		</ul>
	</nav>