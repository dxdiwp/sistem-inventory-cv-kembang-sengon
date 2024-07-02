<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Riwayat Data Hasil Produksi
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('hasilproduksi/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Tambah Data
                    </span>
                </a>
                
                <!-- <button onclick="window.location.href='<?= base_url('hasilproduksi/cetak') ?>'" target="_blank" type="button" id="cetak" name="cari" value="cetak" class="btn btn-sm btn-primary text-white-90 ml-2 py-1"> -->
                <a href="<?= base_url('hasilproduksi/cetak') ?>" target="_blank" type="button" id="cetak" name="cari" value="cetak" class="btn btn-sm btn-primary text-white-90 ml-2 py-1">Cetak</a>

            </div>
        </div>
    </div>

    <!-- <div class="container">
    <form>
        <div class="input-group my-3">
        <select class="form-control" name="periode">
            <option value="">Semua</option>
            <?php foreach($periode as $item) { ?>
            <option value="<?= $item->id ?>" <?= @$_GET['periode']==$item->id?'selected':'' ?>><?= $item->dari ?> - <?= $item->sampai ?></option>
            <?php } ?>
        </select>

        <div class="input-group-append">
                        <button type="submit" id="cari" name="cari" value="cari" class="btn btn-sm btn-primary text-white-50 py-1">
                            <span class="icon">
                                <i class="fa fa-search"></i>
                            </span>
                            <span class="text">
                                    Cari
                                </span>
                        </button>
                    </div>
                </div>
    </form>
    </div> -->

    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <!-- <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Ayam</a>
      </li> -->
      <!-- <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Ayam</a>
      </li> -->
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap dataTable">
    <thead>
        <tr>
            <th>No. </th>
            <th>No Pemasukan</th>
            <th>Tanggal</th>
            <th>Nama Barang</th>
            <th>Jumlah Masuk</th>
            <th>Keterangan</th>
            <th>User</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $no = 1;
    $totalJumlahKeluar = 0; // Inisialisasi total jumlah keluar
    if ($keluarharian) :
        foreach ($keluarharian as $kh) :
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $kh['kd_hasil_produksi']; ?></td>
                <td><?= $kh['tanggal_masuk']; ?></td>
                <td><?= $kh['nama_barang']; ?></td>
                <td><?= $kh['jumlah_masuk'] . ' ' . $kh['nama_satuan']; ?></td>
                <td><?= $kh['keterangan']; ?></td>
                <td><?= $kh['nama']; ?></td>
                <td>
                    <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('hasilproduksi/delete/') . $kh['id_hasil_produksi'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            <?php
            // Tambahkan jumlah keluar ke total
            $totalJumlahKeluar += $kh['jumlah_masuk'];
        endforeach;
    else :
        ?>
        <tr>
            <td colspan="7" class="text-center">
                Data Kosong
            </td>
        </tr>
    <?php endif; ?>
</tbody>

<!-- Tampilkan total jumlah keluar di bawah tabel -->
<tfoot>
    <tr>
        <td colspan="4" align="center"><b>Total Jumlah Masuk</b></td>
        <td align="left"><b><?= $totalJumlahKeluar; ?></b> pcs  </td> 
    </tr>
</tfoot>

</table>


<!-- Script JavaScript -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil semua elemen yang berisi jumlah keluar
        var jumlahKeluarElements = document.querySelectorAll("tbody tr td:nth-child(5)");

        var totalJumlahKeluar = 0;

        // Loop melalui setiap elemen dan tambahkan ke total
        jumlahKeluarElements.forEach(function(element) {
            var jumlahKeluarText = element.textContent.split(' ')[0]; // Ambil bagian angka saja
            var jumlahKeluar = parseFloat(jumlahKeluarText);
            if (!isNaN(jumlahKeluar)) {
                totalJumlahKeluar += jumlahKeluar;
            }
        });

        // Tampilkan total jumlah keluar di bawah tabel
        var totalJumlahKeluarElement = document.createElement('div');
        totalJumlahKeluarElement.textContent = 'Total Jumlah Keluar: ' + totalJumlahKeluar;
        document.body.appendChild(totalJumlahKeluarElement);
    });
</script>

    </div>
      </div>
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap dataTable">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>No Pengeluaran</th>
                    <th>Tanggal Keluar</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Keluar</th>
                    <th>Keterangan</th>
                    <!-- <th>Stok</th> -->
                    <th>User</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $totalJumlahKeluar = 0;
                if ($keluarharianpakan) :
                    foreach ($keluarharianpakan as $kh) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $kh['id_keluar_harian']; ?></td>
                            <td><?= $kh['tanggal_keluar']; ?></td>
                            <td><?= $kh['nama_barang']; ?></td>
                            <td><?= $kh['jumlah_keluar'] . ' ' . $kh['nama_satuan']; ?></td>
                            <td><?= $kh['keterangan']; ?></td>
                            <!-- <td><?= $kh['stok_k']; ?></td> -->
                            <td><?= $kh['nama']; ?></td>
                            <td>
                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('keluarharian/delete/') . $kh['id_keluar_harian'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php  
                    // Tambahkan jumlah keluar ke total
            $totalJumlahKeluar += $kh['jumlah_keluar'];
            endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
    <tr>
        <td colspan="4" align="center"><b>Total Jumlah Keluar</b></td>
        <td align="left"><b><?= $totalJumlahKeluar; ?></b>Karung</td> 
    </tr>
</tfoot>
        </table>
    </div>
      </div>
    </div>

    
</div>