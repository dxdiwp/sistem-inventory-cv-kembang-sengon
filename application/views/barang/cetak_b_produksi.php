<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cetak Barang Produksi</title>

	<style type="text/css">
		@media print {
  @page { margin: 0; }
  body { margin: 1.6cm; }
}
	</style>
</head>
<body onload="window.print()">

	<h1 align="center">Cetak Barang Produksi</h1>

	<table border="1" width="100%" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $total = 0;
                if ($barang) :
                    foreach ($barang as $b) :
                    	$total += $b['stok'];
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $b['kd_b_produksi']; ?></td>
                            <td><?= $b['nama_barang']; ?></td>
                            <td align="right"><?= number_format($b['stok']); ?></td>
                            <td><?= $b['nama_satuan']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                    	<td colspan="3" align="right"><b>Total</b></td>
                    	<td align="right"><b><?= number_format($total); ?></b></td>
                    	<td></td>
                    </tr>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
</body>
</html>