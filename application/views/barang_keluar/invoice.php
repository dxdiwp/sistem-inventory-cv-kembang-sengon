<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cetak Invoice</title>

	<style type="text/css">
		@media print {
  @page { margin: 0; }
  body { margin: 1.6cm; }
}
	</style>
</head>
<body onload="window.print()">

	<h1 align="center">Cetak Invoice <?= $row->id_barang_keluar ?></h1>


    <table border="1" width="50%" style="border-collapse: collapse;" align="center">
        <tr>
            <td>Tanggal Keluar</td>
            <td>:</td>
            <td><?= $row->tanggal_keluar; ?></td>
        </tr>
        <tr>
            <td>Nama Pembeli</td>
            <td>:</td>
            <td><?= $row->nama_pembeli; ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><?= $row->alamat_pembeli; ?></td>
        </tr>
        <tr>
            <td>Nama Barang</td>
            <td>:</td>
            <td><?= $row->nama_barang; ?></td>
        </tr>
        <tr>
            <td>Jumlah Keluar</td>
            <td>:</td>
            <td><?= $row->jumlah_keluar; ?> <?= $row->nama_satuan; ?></td>
        </tr>
        <tr>
            <td>Harga</td>
            <td>:</td>
            <td><?= number_format($row->harga); ?></td>
        </tr>
        <tr>
            <td>Subtotal</td>
            <td>:</td>
            <td><?= number_format($row->harga*$row->jumlah_keluar); ?></td>
        </tr>
    </table>

	
</body>
</html>