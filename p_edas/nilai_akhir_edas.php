<?php 
	include('../config.php');
	include('../fungsi.php');

	include('header.php');
?>

<section class="content">
    <!-- Tabel Jumlah Terbobot -->
	<h2 class="ui header">Data Hasil Akhir</h2>
	
	<table class="ui celled red table">
		<thead>
			<tr>
				<th class="collapsing">No</th>
				<th colspan="1">Nama Alternatif</th>
                <th colspan="1">Alternatif</th>
				<th colspan="1">AS</th>
				<th colspan="1">Ranking</th>
			</tr>
		</thead>
		<tbody>

		<?php
			$query = "SELECT id_alternatif, alternatif_C, nama , q FROM alternatif ORDER BY q DESC"; // Ambil data yang sudah diurutkan berdasarkan nilai q secara descending
            $result = mysqli_query($koneksi, $query);
    
            $i = 0;
            while ($row = mysqli_fetch_array($result)) {
                $i++;
                // Memperbarui kolom ranking dengan nomor peringkat
                $id_alternatif = $row['id_alternatif'];
                $update_ranking_query = "UPDATE alternatif SET ranking = $i WHERE id_alternatif = $id_alternatif";
                $update_ranking_result = mysqli_query($koneksi, $update_ranking_query);
                if (!$update_ranking_result) {
                    die("Query error: " . mysqli_error($koneksi));
                }
        ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row['nama'] ?></td>
                <td><?php echo $row['alternatif_C'] ?></td>
                <td><?php echo number_format($row['q'], 3) ?></td>
                <?php if ($i == 1) {
						echo "<td><div class=\"ui ribbon label\">Pertama</div></td>";
					} else {
						echo "<td>".$i."</td>";
					}

					?>
            </tr>
	<?php } ?>
		</tbody>
	</table>
</section>

<?php include('../footer.php'); ?>
