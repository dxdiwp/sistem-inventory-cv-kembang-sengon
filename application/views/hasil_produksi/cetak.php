<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Hasil Produksi</title>
    <style type="text/css">
        table {
            border-collapse: collapse;
        }
        @media print {
  @page { margin: 0; }
  body { margin: 1.6cm; }
}
    
    </style>
</head>
<body>
    <!-- Tambahkan logika untuk menampilkan tombol cetak hanya saat tidak dalam mode cetak -->
    <!-- <?php if (!isset($_GET['cetak'])) : ?>
        <button onclick="window.location.href='<?php echo base_url('controller/index?cetak=1'); ?>';">Cetak</button>
    <?php endif; ?> -->

    <h1 align="center">Hasil Produksi</h1>
    <hr>

    <table border="1" width="100%">
        <tr>
            <th>No</th>
            <th>No Pengeluaran</th>
            <th>Tanggal Keluar</th>
            <th>Nama Barang</th>
            <th>Jumlah Keluar</th>
            <th>Keterangan</th>
            <th>User</th>
        </tr>
        <?php 
        $no=1;
        $modal = 0;
        $pemasukan = 0;
        $pengeluaran = 0;

        foreach ($keluarharian as $kh) { 
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $kh['id_hasil_produksi']; ?></td>
            <td><?= $kh['tanggal']; ?></td>
            <td><?= $kh['nama_barang']; ?></td>
            <td><?= $kh['jumlah_masuk'] . ' ' . $kh['nama_satuan']; ?></td>
            <td><?= $kh['keterangan']; ?></td>
            <td><?= $kh['nama']; ?></td>
        </tr>
        <?php } ?>
    </table>

    <!-- Tambahkan kode JavaScript untuk melakukan cetak otomatis saat halaman dimuat -->
    <script type="text/javascript">
        // Hanya jalankan fungsi cetak saat tidak dalam mode cetak
        if (!window.location.search.includes('cetak')) {
            window.onload = function() {
                window.print();
            };
        }
    </script>
</body>
</html>
