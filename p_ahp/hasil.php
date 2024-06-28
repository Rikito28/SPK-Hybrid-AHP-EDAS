<?php

include('../config.php');
include('../fungsi.php');


// menghitung perangkingan
$jmlAlternatif	= getJumlahAlternatif();

include('header.php');

?>

<section class="content">
	<h2 class="ui header">Hasil Perhitungan</h2>
	<table class="ui celled table">
		<thead>
		<tr>
			<th>Overall Composite Height</th>
			<th>Priority Vector (rata-rata)</th>
			<th>Bobot</th>
			<th>Eigen Value</th>
		</tr>
		</thead>
		<tbody>

		<?php
			$totalPV = 0;
			$totalBobot = 0;
			$totalEI = 0;

			for ($x = 0; $x <= (getJumlahKriteria() - 1); $x++) {
				$idKriteria = getKriteriaID($x);

				$PV = getPVektor($idKriteria);
				$bobot = getKriteriaPV($idKriteria);
				$EI = getEI($idKriteria);

				$totalPV += $PV;
				$totalBobot += $bobot;
				$totalEI += $EI;

				echo "<tr>";
				echo "<td>" . getKriteriaNama($x) . "</td>";
				echo "<td>" . round($PV, 3) . "</td>";
				echo "<td>" . round($bobot, 3) . "</td>";
				echo "<td>" . round($EI, 3) . "</td>";
				echo "</tr>";
			}
			?>
		</tbody>

		<tfoot>
		<tr>
			<th colspan="1">Total</th>
			<td><?= round($totalPV, 3) ?></td>
				<td><?= round($totalBobot, 3) ?></td>
				<td><?= round($totalEI, 3) ?></td>
		</tr>
		</tfoot>

	</table>
</section>

<?php include('../footer.php'); ?>