<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Riwayat Data Pembelian Bahan Produksi
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('barangmasuk/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Input Data Pembelian
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
                <a href="<?= base_url('barangmasuk/cetak') ?>" class="btn btn-sm btn-primary btn-icon-split" target>
                  
                    <span class="text">
                        Cetak
                    </span>
                </a>
            </div>           
                </div>
                
    </form>


    </div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Bahan Produksi</a>
      </li>
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
                    <th>No Transaksi</th>
                    <th>Tanggal Masuk</th>
                    <th>Supplier</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Masuk</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                    <!-- <th>User</th> -->
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($barangmasuk) :
                    foreach ($barangmasuk as $bm) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $bm['kd_barang_masuk']; ?></td>
                            <td><?= $bm['tanggal_masuk']; ?></td>
                            <td><?= $bm['nama_supplier']; ?></td>
                            <td><?= $bm['nama_barang']; ?></td>
                            <td><?= $bm['jumlah_masuk'] . ' ' . $bm['nama_satuan']; ?></td>
                            <td><?= number_format($bm['harga']); ?></td>
                            <td><?= number_format($bm['harga']*$bm['jumlah_masuk']); ?></td>
                            <!-- <td><?= $bm['nama']; ?></td> -->
                            <td>
                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('barangmasuk/delete/') . $bm['id_barang_masuk'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
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
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="table-responsive">
        
        <table class="table table-striped w-100 dt-responsive nowrap dataTable">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>No Transaksi</th>
                    <th>Tanggal Masuk</th>
                    <th>Supplier</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Masuk</th>
                    <!-- <th>User</th> -->
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($barangmasuk) :
                    foreach ($barangmasuk as $bm) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $bm['id_barang_masuk']; ?></td>
                            <td><?= $bm['tanggal_masuk']; ?></td>
                            <td><?= $bm['nama_supplier']; ?></td>
                            <td><?= $bm['nama_barang']; ?></td>
                            <td><?= $bm['jumlah_masuk'] . ' ' . $bm['nama_satuan']; ?></td>
                            <!-- <td><?= $bm['nama']; ?></td> -->
                            <td>
                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('barangmasuk/delete/') . $bm['id_barang_masuk'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
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
     </div>
</div>