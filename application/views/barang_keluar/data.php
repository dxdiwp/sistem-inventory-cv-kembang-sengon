<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Riwayat Data Penjualan Tripleks
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('barangkeluar/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Input Penjualan
                    </span>
                </a>
            </div>
        </div>
    </div>


    <div class="container">
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
                            <!-- <span class="text">
                                    Cari
                                </span> -->
                        </button>
                    </div>
                    <div class="col-auto">
                <a href="<?= base_url('barangkeluar/cetak') ?>" class="btn btn-sm btn-primary btn-icon-split" target="_blank">
                  
                    <span class="text">
                        Cetak
                    </span>
                </a>
            </div>        
                </div>
    </form>

    

    </div>
    
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
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
                    <!-- <th>User</th> -->
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($barangkeluar) :
                    foreach ($barangkeluar as $bk) :
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
                            <!-- <td><?= $bk['nama']; ?></td> -->
                            <td>
                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('barangkeluar/delete/') . $bk['id_barang_keluar'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
                                <!-- <a onclick="return confirm('Print the letter?')" href="<?= base_url('barangkeluar/faktur_surat_jalan/') . $bk['id_barang_keluar'] ?>" class="btn btn-success btn-circle btn-sm"><i class="fa fa-car"></i></a> -->
                                <a onclick="return confirm('Print Invoice?')" href="<?= base_url('barangkeluar/invoice/') . $bk['id_barang_keluar'] ?>" class="btn btn-info btn-circle btn-sm" target="_blank"><i class="fa fa-book"></i></a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>