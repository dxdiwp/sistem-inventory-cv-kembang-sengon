<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Form Edit Keuangan
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('keuangan') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                            <span class="icon">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">
                                Kembali
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <?= form_open('', [], ['id_keuangan' => $keuangan['id_keuangan']]); ?>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="tgl">Tanggal</label>
                    <div class="col-md-9">
                        <input value="<?= set_value('tgl', date('Y-m-d')); ?>" name="tgl" id="tgl" type="text" class="form-control date">
                        <?= form_error('tgl', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="pengeluaran">Jenis</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <select class="form-control" name="jenis">
                                <option <?= $keuangan['jenis']=='Modal'?'selected':'' ?>>Modal</option>
                                <option <?= $keuangan['jenis']=='Pengeluaran'?'selected':'' ?>>Pengeluaran</option>
                                <option <?= $keuangan['jenis']=='Pemasukan'?'selected':'' ?>>Pemasukan</option>
                            </select>
                        </div>
                        <?= form_error('pengeluaran', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="harga">Nominal</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input value="<?= set_value('nominal', $keuangan['nominal']); ?>" name="nominal" id="nominal" type="text" class=" form-control form-control-sm uang">
                        </div>
                        <?= form_error('nominal', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="ket">Keterangan</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <textarea name="keterangan" id="ket" class="form-control" rows="4"><?= set_value('keterangan', $keuangan['keterangan']); ?></textarea>
                        </div>
                        <?= form_error('keterangan', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-9 offset-md-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
</div>
        </div>
    </div>
</div>