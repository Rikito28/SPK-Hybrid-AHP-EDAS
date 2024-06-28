<?php
	include('../config.php');
	include('../fungsi.php');

	// mendapatkan data edit
	if(isset($_GET['jenis']) && isset($_GET['id'])) {
		$id 	= $_GET['id'];
		$jenis	= $_GET['jenis'];

		// hapus record
		$query 	= "SELECT nama, atribut FROM kriteria_edas WHERE id_kriteria=$id";
		$result	= mysqli_query($koneksi, $query);
		
		while ($row = mysqli_fetch_array($result)) {
			$nama = $row['nama'];
			$atribut = $row['atribut'];
		}
	}

	if (isset($_POST['update'])) {
		$id 	= $_POST['id'];
		$jenis	= $_POST['jenis'];
		$nama 	= $_POST['nama'];
		$atribut = $_POST['atribut'];

		$query 	= "UPDATE kriteria_edas SET nama='$nama', atribut='$atribut' WHERE id_kriteria=$id";
		$result	= mysqli_query($koneksi, $query);

		if (!$result) {
			echo "Update gagal";
			exit();
		} else {
			header('Location: kriteria.php');
			exit();
		}
	}

	include('header.php');
?>

<section class="content">
	<h2>Edit <?php echo $jenis?></h2>

	<form class="ui form" method="post" action="edit_kriteria.php">
		<div class="inline field">
			<label>Nama <?php echo $jenis ?></label>
			<input type="text" name="nama" value="<?php echo $nama?>">
			<input type="text" name="atribut" value="<?php echo $atribut?>">
			<input type="hidden" name="id" value="<?php echo $id?>">
			<input type="hidden" name="jenis" value="<?php echo $jenis?>">
		</div>
		<br>
		<input class="ui green button" type="submit" name="update" value="UPDATE">
	</form>
</section>

<?php include('../footer.php'); ?>