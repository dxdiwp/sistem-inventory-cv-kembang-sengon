<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <!-- <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>
            </ol> -->
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<?php if (is_admin()) { ?>

    <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $barang ?></h3>

                <p>Total Data Barang</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $user ?></h3>

                <p>Total User</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?= base_url('user') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $supplier ?></h3>

                <p>Data Supplier</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?= base_url('supplier') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?= number_format($stok) ?></h3>

                <p>Total Stok</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>


<div class="mb-5">
    <form method="post" action="<?= base_url('dashboard/periode') ?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Dari</label>
                    <input type="date" name="dari" value="<?= @$periode->dari ?>" class="form-control">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Sampai</label>
                    <input type="date" name="sampai" value="<?= @$periode->sampai ?>" class="form-control">
                </div>
            </div>
            <div class="col-2 my-auto">
                <button type="submit" class="btn btn-primary" name="action" value="update">Update Periode</button>
            </div>
            <div class="col-2 my-auto">
                <button type="submit" class="btn btn-primary" name="action" value="next">Next Periode</button>
            </div>
        </div>

        
    </form>
</div>

<div class="row">
 <div class="col">
     <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-danger">Grafik Hasil Produksi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                    <hr>
                                </div>
                            </div>
 </div>
</div>

<!-- <div class="row">
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary py-3">
                <h6 class="m-0 font-weight-bold text-white text-center">Transaksi Terakhir Barang Masuk</h6>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 table-sm table-striped text-center">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transaksi['barang_masuk'] as $tbm) : ?>
                            <tr>
                                <td><strong><?= $tbm['tanggal_masuk']; ?></strong></td>
                                <td><?= $tbm['nama_barang']; ?></td>
                                <td><span class="badge badge-primary"><?= $tbm['jumlah_masuk']; ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header bg-danger py-3">
                <h6 class="m-0 font-weight-bold text-white text-center">Transaksi Terakhir Barang Keluar</h6>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 table-sm table-striped text-center">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transaksi['barang_keluar'] as $tbk) : ?>
                            <tr>
                                <td><strong><?= $tbk['tanggal_keluar']; ?></strong></td>
                                <td><?= $tbk['nama_barang']; ?></td>
                                <td><span class="badge badge-danger"><?= $tbk['jumlah_keluar']; ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header bg-success py-3">
                <h6 class="m-0 font-weight-bold text-white text-center">Transaksi Terakhir Pengeluaran</h6>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 table-sm table-striped text-center">
                    <thead>
                        <tr>
                        <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transaksi['keluar_harian'] as $tbkh) : ?>
                            <tr>
                                <td><strong><?= $tbkh['tanggal_keluar']; ?></strong></td>
                                <td><?= $tbkh['nama_barang']; ?></td>
                                <td><span class="badge badge-success"><?= $tbkh['jumlah_keluar']; ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> -->
    <?php } else { ?>
        <div class="col-xl-3 col-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Stok</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stok; ?></div>
                            </div>
                            <div class="col-auto">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header bg-success py-3">
                <h6 class="m-0 font-weight-bold text-white text-center">Detail Stok</h6>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 table-sm table-striped text-center">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transaksi['total'] as $t) : ?>
                            <tr>
                                
                                <td><?= $t['nama_barang']; ?></td>
                                <td><span class="badge badge-primary"><?= $t['stok']; ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Data Pengeluaran</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $keluar_harian; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-table fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>