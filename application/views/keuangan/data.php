<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Data Keuangan
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('keuangan/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Tambah Keuangan
                    </span>
                </a>
            </div>
        </div>
        <div class="row">
            <form>
            <div class="">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-fw fa-calendar"></i></span>
                    </div>
                    <select class="form-control" name="periode">
                        <option value="">Semua</option>
                        <?php foreach($periode as $item) { ?>
                        <option value="<?= $item->id ?>" <?= @$_GET['periode']==$item->id?'selected':'' ?>><?= $item->dari ?> - <?= $item->sampai ?></option>
                        <?php } ?>
                    </select>
                    <!-- <input value="<?= @$_GET['tgl_mulai']; ?>" name="tgl_mulai" id="tgl_mulai" type="date" class="form-control" placeholder="Periode Tanggal">
                    <input value="<?= @$_GET['tgl_selesai']; ?>" name="tgl_selesai" id="tgl_selesai" type="date" class="form-control" placeholder="Periode Tanggal"> -->
                    <select class="form-control" name="jenis">
                        <option <?= @$_GET['jenis']=='Semua'?'selected':'' ?>>Semua</option>
                        <!-- <option <?= @$_GET['jenis']=='Modal'?'selected':'' ?>>Modal</option> -->
                        <option <?= @$_GET['jenis']=='Pengeluaran'?'selected':'' ?>>Pengeluaran</option>
                        <option <?= @$_GET['jenis']=='Pemasukan'?'selected':'' ?>>Pemasukan</option>
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
                        <button type="submit" id="cetak" name="cari" value="cetak" class="btn btn-sm btn-primary text-white-90 ml-2 py-1">
                            Cetak
                            <!-- <span class="text">
                                    Cari
                                </span> -->
                        </button>
                    </div>
                </div>
                <?= form_error('tanggal', '<small class="text-danger">', '</small>'); ?>
            </div>
            </form>


            <div class="">

            </div>
            </form>
        </div>

    </div>
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Keterangan</th>
                    <th>Nominal</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($keuangan) :
                    $no = 1;
                    foreach ($keuangan as $k) :
                ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $k['tgl']; ?></td>
                            <td><?= $k['jenis']; ?></td>
                            <td><?= $k['keterangan']; ?></td>
                            <td>Rp. <?= number_format($k['nominal'], 0, ',', '.'); ?></td>
                            
                            <th>
                                <a href="<?= base_url('keuangan/edit/') . $k['id_keuangan'] ?>" class="btn btn-circle btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('keuangan/delete/') . $k['id_keuangan'] ?>" class="btn btn-circle btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                            </th>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>