<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cetak Barang Masuk</title>

	<style type="text/css">
		@media print {
  @page { margin: 0; }
  body { margin: 1.6cm; }
}
	</style>
</head>
<body onload="window.print()">

	<h1 align="center">Cetak Barang Masuk</h1>

	<table border="1" width="100%" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>No Transaksi</th>
                    <th>Tanggal Masuk</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Masuk</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                    <!-- <th>Total Netto</th> -->
                    <!-- <th>Berat Rata-Rata</th> -->
                    <!-- <th>Nama Pembeli</th> -->
                    <!-- <th>Alamat </th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $total = 0;
                if ($barangmasuk) :
                    foreach ($barangmasuk as $bm) :
                        $total += $bm['harga']*$bm['jumlah_masuk'];
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $bm['kd_barang_masuk']; ?></td>
                            <td><?= $bm['tanggal_masuk']; ?></td>
                            <td><?= $bm['nama_barang']; ?></td>
                            <td><?= $bm['jumlah_masuk'] . ' ' . $bm['nama_satuan']; ?></td>
                            <td align="right"><?= number_format($bm['harga']); ?></td>
                            <td align="right"><?= number_format($bm['harga']*$bm['jumlah_masuk']); ?></td>
                            <!-- <td><?= $bm['total_berat']; ?></td> -->
                            <!-- <td><?= $bm['rata']; ?></td> -->
                            <!-- <td><?= $bm['nama_pembeli']; ?></td> -->
                            <!-- <td><?= $bm['alamat_pembeli']; ?></td> -->

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