<?php
	include('../config.php');
	include('../fungsi.php');

	// mendapatkan data edit
	if(isset($_GET['jenis']) && isset($_GET['id'])) {
		$id 	= $_GET['id'];
		$jenis	= $_GET['jenis'];

		// hapus record
		$query 	= "SELECT nama, alternatif_C FROM alternatif WHERE id_alternatif=$id";
		$result	= mysqli_query($koneksi, $query);
		
		while ($row = mysqli_fetch_array($result)) {
			$nama = $row['nama'];
			$alternatif_C = $row['alternatif_C'];
		}
	}

	if (isset($_POST['update'])) {
		$id 	= $_POST['id'];
		$jenis	= $_POST['jenis'];
		$nama 	= $_POST['nama'];
		$alternatif_C = $_POST['alternatif_C'];

		$query 	= "UPDATE alternatif SET nama='$nama', alternatif_C='$alternatif_C' WHERE id_alternatif=$id";
		$result	= mysqli_query($koneksi, $query);

		if (!$result) {
			echo "Update gagal";
			exit();
		} else {
			header('Location: alternatif.php');
			exit();
		}
	}

	include('header.php');
?>

<section class="content">
	<h2>Edit <?php echo $jenis?></h2>

	<form class="ui form" method="post" action="edit_alternatif.php">
		<div class="inline field">
			<label>Nama <?php echo $jenis ?></label>
			<input type="text" name="nama" value="<?php echo $nama?>">
			<input type="text" name="alternatif_C" value="<?php echo $alternatif_C?>">
			<input type="hidden" name="id" value="<?php echo $id?>">
			<input type="hidden" name="jenis" value="<?php echo $jenis?>">
		</div>
		<br>
		<input class="ui green button" type="submit" name="update" value="UPDATE">
	</form>
</section>

<?php include('../footer.php'); ?>