<?php
	include('header.php');

?>

<section class="content">
	<h3 class="ui header">Matriks Perbandingan Berpasangan</h3>
	<table class="ui collapsing celled blue table">
		<thead>
			<tr>
				<th>Kriteria</th>
<?php
	for ($i=0; $i <= ($n-1); $i++) { 
		echo "<th>".getKriteriaNama($i)."</th>";
	}
?>
			</tr>
		</thead>
		<tbody>
<?php
	for ($x=0; $x <= ($n-1); $x++) { 
		echo "<tr>";
		echo "<td>".getKriteriaNama($x)."</td>";
			for ($y=0; $y <= ($n-1); $y++) { 
				echo "<td>".round($matrik[$x][$y],3)."</td>";
			}

		echo "</tr>";
	}
?>
		</tbody>
		<tfoot>
			<tr>
				<th>Jumlah</th>
<?php
		for ($i=0; $i <= ($n-1); $i++) { 
			echo "<th>".round($jmlmpb[$i],3)."</th>";
		}
?>
			</tr>
		</tfoot>
	</table>


	<br>

	<h3 class="ui header">Matriks Nilai Kriteria</h3>
	<table class="ui celled red table">
		<thead>
			<tr>
				<th>Kriteria</th>
<?php
	for ($i=0; $i <= ($n-1); $i++) { 
		echo "<th>".getKriteriaNama($i)."</th>";
	}
?>
				<th>P. Vektor</th>
				<th>Bobot</th>
				<th>Eigen Value</th>
			</tr>
		</thead>
		<tbody>
<?php
	for ($x=0; $x <= ($n-1); $x++) { 
		echo "<tr>";
		echo "<td>".getKriteriaNama($x)."</td>";
			for ($y=0; $y <= ($n-1); $y++) { 
				echo "<td>".round($matrikb[$x][$y],5)."</td>";
			}

		echo "<td>".round($jmlmnk[$x],3)."</td>";
		echo "<td>".round($pv[$x],3)."</td>";
		echo "<td>".round($ei[$x],3)."</td>";

		echo "</tr>";
	}
?>
			
		</tbody>
		<tfoot>
			<tr>
				<th colspan="<?php echo ($n+3)?>">Principe Eigen Vector (λ maks)</th>
				<th><?php echo (round($eigenvektor,5))?></th>
			</tr>
			<tr>
				<th colspan="<?php echo ($n+3)?>">Consistency Index</th>
				<th><?php echo (round($consIndex,5))?></th>
			</tr>
			<tr>
				<th colspan="<?php echo ($n+3)?>">Consistency Ratio</th>
				<th><?php echo (round(($consRatio * 100),2))?> %</th>
			</tr>
		</tfoot>
	</table>

<?php
	if ($consRatio > 0.1) {
?>
		<div class="ui icon red message">
			<i class="close icon"></i>
			<i class="warning circle icon"></i>
			<div class="content">
				<div class="header">
					Nilai Consistency Ratio melebihi 10% !!!
				</div>
				<p>Mohon input kembali tabel perbandingan...</p>
			</div>
		</div>

		<br>

		<a href='javascript:history.back()'>
			<button class="ui left labeled icon button">
				<i class="left arrow icon"></i>
				Kembali
			</button>
		</a>

<?php
	} else {

?>
<br>

	<a href="hasil.php">
	<button class="ui right labeled icon button" style="float: right;">
		<i class="right arrow icon"></i>
		Lanjut
	</button>
	</a>

<?php 
	}
	echo "</section>";
	include('../footer.php');
?>