<?php 
	include('../config.php');
	include('../fungsi.php');

	include('header.php');
?>

<section class="content">
    <!-- Tabel Jumlah Terbobot -->
	<h2 class="ui header">Menentukan Jumlah Nilai Terbobot</h2>
	
	<table class="ui celled red table">
		<thead>
			<tr>
				<th class="collapsing">No</th>
				<th colspan="1">Nama Alternatif</th>
				<th colspan="1">SP</th>
				<th colspan="1">SN</th>
			</tr>
		</thead>
		<tbody>

		<?php
			// Menampilkan list kriteria
			$query = "SELECT id_alternatif,nama,j_sp,j_sn FROM alternatif ORDER BY id_alternatif";
			$result	= mysqli_query($koneksi, $query);

			$i = 00;
			while ($row = mysqli_fetch_array($result)) {
				$i++;
		?>
			<tr>
				<td><?php echo $i ?></td>
				<td><?php echo $row['nama'] ?></td>
                <td><?php echo number_format($row['j_sp'], 3) ?></td>
                <td><?php echo number_format($row['j_sn'], 3) ?></td>
				</td>
			</tr>
	<?php } ?>
		</tbody>
	</table>
	
    <!-- Tabel Normalisasi SP/SN -->
    <h2 class="ui header">Normalisasi Nilai SP/SN</h2>
	<table class="ui celled red table">
		<thead>
			<tr>
				<th class="collapsing">No</th>
				<th colspan="1">Nama Alternatif</th>
				<th colspan="1">NSP</th>
				<th colspan="1">NSN</th>
			</tr>
		</thead>
		<tbody>

		<?php
			// Menampilkan list kriteria
			$query = "SELECT id_alternatif,nama,nsp,nsn FROM alternatif ORDER BY id_alternatif";
			$result	= mysqli_query($koneksi, $query);

			$i = 00;
			while ($row = mysqli_fetch_array($result)) {
				$i++;
		?>
			<tr>
				<td><?php echo $i ?></td>
				<td><?php echo $row['nama'] ?></td>
                <td><?php echo number_format($row['nsp'], 3) ?></td>
                <td><?php echo number_format($row['nsn'], 3) ?></td>
				</td>
			</tr>
	<?php } ?>
		</tbody>
	</table>

	<form action="nilai_akhir_edas.php">
	<button class="ui right labeled icon button" style="float: right;">
		<i class="right arrow icon"></i>
		Lanjut
	</button>
	</form>

</section>

<?php include('../footer.php'); ?>
