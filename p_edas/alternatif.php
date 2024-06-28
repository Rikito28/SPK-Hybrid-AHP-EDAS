<?php 
	include('../config.php');
	include('../fungsi.php');

	// menjalankan perintah edit
	if(isset($_POST['edit'])) {
		$id = $_POST['id'];

		header('Location: edit_alternatif.php?jenis=alternatif&id='.$id);
		exit();
	}

	include('header.php');

?>


<section class="content">

	<h2 class="ui header">Alternatif</h2>

	<table class="ui celled green table">
		<thead>
			<tr>
				<th class="collapsing">No</th>
				<th colspan="1">Nama Alternatif</th>
				<th colspan="2">Alternatif</th>
			</tr>
		</thead>
		<tbody>

		<?php
			// Menampilkan list alternatif
			$query = "SELECT id_alternatif,nama,alternatif_C FROM alternatif ORDER BY id_alternatif";
			$result	= mysqli_query($koneksi, $query);

			$i = 0;
			while ($row = mysqli_fetch_array($result)) {
				$i++;
		?>
			<tr>
				<td><?php echo $i ?></td>
				<td><?php echo $row['nama'] ?></td>
				<td><?php echo $row['alternatif_C'] ?></td>
				<td class="right aligned collapsing">
					<form method="post" action="alternatif.php">
						<input type="hidden" name="id" value="<?php echo $row['id_alternatif'] ?>">
						<button type="submit" name="edit" class="ui mini teal left labeled icon button"><i class="right edit icon"></i>EDIT</button>
					</form>
				</td>
			</tr>

<?php } ?>
	
		</tbody>
	</table>

	<br><br>


	<form action="matriks.php">
	<button class="ui right labeled icon button" style="float: right;">
		<i class="right arrow icon"></i>
		Lanjut
	</button>
	</form>
</section>

<?php include('../footer.php'); ?>