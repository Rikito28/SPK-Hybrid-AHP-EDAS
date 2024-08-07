<?php 
	include('../config.php');
	include('../fungsi.php');

	// menjalankan perintah edit
	if(isset($_POST['edit'])) {
		$id = $_POST['id'];

		header('Location: edit_kriteria.php?jenis=kriteria&id='.$id);
		exit();
	}
	
	include('header.php');
?>

<section class="content">
	<h2 class="ui header">Kriteria</h2>
	
	<table class="ui celled green table">
		<thead>
			<tr>
				<th class="collapsing">No</th>
				<th colspan="1">Nama Kriteria</th>
				<th colspan="1">Bobot</th>
				<th colspan="2">Jenis</th>
			</tr>
		</thead>
		<tbody>

		<?php
			// Menampilkan list kriteria
			$query = "SELECT id_kriteria,nama,bobot,atribut FROM kriteria_edas ORDER BY id_kriteria";
			$result	= mysqli_query($koneksi, $query);

			$i = 00;
			while ($row = mysqli_fetch_array($result)) {
				$i++;
		?>
			<tr>
				<td><?php echo $i ?></td>
				<td><?php echo $row['nama'] ?></td>
				<td><?php echo number_format($row['bobot'],3) ?></td>
				<td><?php echo $row['atribut'] ?></td>
				<td class="right aligned collapsing">
					<form method="post" action="kriteria.php">
						<input type="hidden" name="id" value="<?php echo $row['id_kriteria'] ?>">
						<button type="submit" name="edit" class="ui mini teal left labeled icon button"><i class="right edit icon"></i>EDIT</button>
					</form>
				</td>
			</tr>
		

	<?php } ?>
		</tbody>
	</table>

	<br>



	<form action="alternatif.php">
	<button class="ui right labeled icon button" style="float: right;">
		<i class="right arrow icon"></i>
		Lanjut
	</button>
	</form>

</section>

<?php include('../footer.php'); ?>
