<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cetak Barang Keluar</title>

	<style type="text/css">
		@media print {
  @page { margin: 0; }
  body { margin: 1.6cm; }
}
	</style>
</head>
<body onload="window.print()">

	<h1 align="center">Cetak Barang Keluar</h1>

	<table border="1" width="100%" style="border-collapse: collapse;">
        <thead>
                <tr>
                    <th>No. </th>
                    <th>No Transaksi</th>
                    <th>Tanggal Keluar</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Keluar</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                    <!-- <th>Total Netto</th> -->
                    <!-- <th>Berat Rata-Rata</th> -->
                    <th>Nama Pembeli</th>
                    <th>Alamat </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $total = 0;
                if ($barangkeluar) :
                    foreach ($barangkeluar as $bk) :
                    $total += $bk['harga']*$bk['jumlah_keluar'];
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $bk['id_barang_keluar']; ?></td>
                            <td><?= $bk['tanggal_keluar']; ?></td>
                            <td><?= $bk['nama_barang']; ?></td>
                            <td><?= $bk['jumlah_keluar'] . ' ' . $bk['nama_satuan']; ?></td>
                            <td><?= number_format($bk['harga']); ?></td>
                            <td><?= number_format($bk['harga']*$bk['jumlah_keluar']); ?></td>
                            <!-- <td><?= $bk['total_berat']; ?></td> -->
                            <!-- <td><?= $bk['rata']; ?></td> -->
                            <td><?= $bk['nama_pembeli']; ?></td>
                            <td><?= $bk['alamat_pembeli']; ?></td>

                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="6" align="right"></td>
                        <td align="right"><?= number_format($total) ?></td>
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