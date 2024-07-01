<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cetak Keuangan</title>
	<style type="text/css">
		table {
			border-collapse: collapse;
		}
	</style>
</head>
<body onload="window.print()">
	<h1 align="center">Laporan Keungan</h1>
	<hr>

	<table border="1" width="100%">
		<tr>
			<th>No</th>
			<th>Tanggal</th>
			<th>Jenis</th>
			<th>Keterangan</th>
			<th>Nominal</th>
		</tr>
		<?php 
		$modal = 0;$pemasukan = 0;$pengeluaran=0;
		foreach ($keuangan as $key => $item) { 
			if ($item['jenis'] == 'Modal') {
				$modal += $item['nominal'];
			}
			if ($item['jenis'] == 'Pemasukan') {
				$pemasukan += $item['nominal'];
			}
			if ($item['jenis'] == 'Pengeluaran') {
				$pengeluaran += $item['nominal'];
			}
			?>
		<tr>
			<td><?= $key+=1 ?></td>
			<td><?= date('d-m-Y',strtotime($item['tgl'])) ?></td>
			<td><?= $item['jenis'] ?></td>
			<td><?= $item['keterangan'] ?></td>
			<td align="right">Rp <?= number_format($item['nominal']) ?></td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="4" align="right"><b>Modal</b></td>
			<td align="right"><b>Rp <?= number_format($modal) ?></b></td>
		</tr>
		<tr>
			<td colspan="4" align="right"><b>Pengeluaran</b></td>
			<td align="right"><b>( Rp <?= number_format($pengeluaran) ?> )</b></td>
		</tr>
		<tr>
			<td colspan="4" align="right"><b>Pemasukan</b></td>
			<td align="right"><b>Rp <?= number_format($pemasukan) ?></b></td>
		</tr>
		<tr>
			<td colspan="4" align="right"><b>Laba/Rugi</b></td>
			<td align="right"><b>Rp <?= number_format($modal-$pengeluaran+$pemasukan) ?></b></td>
		</tr>
	</table>
</body>
</html>