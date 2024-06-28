
<?php
include('../config.php');
include('../fungsi.php');

// header
include('header.php');
?>

	<section class="content">
			<h2 class="ui header">Evaluation based on Distance from Average Solution (EDAS)</h2>

			<h3>Metode Evaluation based on Distance from Average Solution (EDAS) merupakan salah satu metode pengambilan keputusan multikriteria berdasarkan pada skor penilaian Apraisal Score (AS) tertinggi untuk mendapatkan pilihan terbaik dari semua alternatif. </h3>

			<br>

			<h3 class="ui header">Tahapan Pada Metode Edas</h3>
			<table class="ui collapsing striped blue table">
				<thead>
					<tr>
						<th>No.</th>
						<th>Tahapan</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="center aligned">1.</td>
						<td>Pembentukan Matriks Keputusan (X)</td>
					</tr>
					<tr>
						<td class="center aligned">2.</td>
						<td>Menetukan Solusi Rata-rata <i>Average Solution</i> (AV)</td>
					</tr>
					<tr>
						<td class="center aligned">3.</td>
						<td>Menentukan Jarak Positif/Negatif dari Rata-rata (PDA/NDA)</td>
					</tr>
					<tr>
						<td class="center aligned">4.</td>
						<td>Menentukan Jumlah Terbobot dari PDA/NDA (SP/SN)</td>
					</tr>
					<tr>
						<td class="center aligned">5.</td>
						<td>Normalisasi Nilai SP/SN (NSP/NSN)</td>
					</tr>
					<tr>
						<td class="center aligned">6</td>
						<td>Menghitung Nilai Skor Penilaian (AS)</td>
					</tr>
					<tr>
						<td class="center aligned">7</td>
						<td>Perankingan</td>
					</tr>
				</tbody>
			</table>

	</section>

<?php include('../footer.php'); ?>
