<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Input Data Pengeluaran
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('keluarharian') ?>" class="btn btn-sm btn-secondary btn-icon-split">
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
                <?= form_open('', [], ['kd_keluar_harian' => $kd_keluar_harian, 'user_id' => $this->session->userdata('login_session')['user']]); ?>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="id_keluar_harian">ID Pengeluaran Harian</label>
                    <div class="col-md-4">
                        <input value="<?= $kd_keluar_harian; ?>" type="text" readonly="readonly" class="form-control">
                        <?= form_error('kd_keluar_harian', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="tanggal_keluar">Tanggal Keluar</label>
                    <div class="col-md-4">
                        <input value="<?= set_value('tanggal_keluar', date('Y-m-d')); ?>" name="tanggal_keluar" id="tanggal_keluar" type="text" class="form-control date" placeholder="Tanggal Masuk...">
                        <?= form_error('tanggal_keluar', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="barang_id">Barang</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <select name="barang_id" id="barang_id" class="custom-select">
                                <option value="" selected disabled>Pilih Barang</option>
                                <?php foreach ($barang as $b) : ?>
                                    <option value="<?= $b['id_barang'] ?>"><?= $b['kd_b_baku'] . ' | ' . $b['nama_barang'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <a class="btn btn-primary" href="<?= base_url('bahanbaku/add'); ?>"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <?= form_error('barang_id', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="stok">Stok</label>
                    <div class="col-md-5">
                        <!-- <input readonly="readonly" id="stok" type="number" class="form-control" value="<?= @$barang['0']['stok'] ?>"> -->
                        <input readonly="readonly" id="stok" name="stok" type="number" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="jumlah_keluar">Jumlah Keluar</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <input value="<?= set_value('jumlah_keluar'); ?>" name="jumlah_keluar" id="jumlah_keluar" type="number" class="form-control" placeholder="Jumlah Keluar...">
                            <div class="input-group-append">
                                <span class="input-group-text" id="satuan">Satuan</span>
                            </div>
                        </div>
                        <?= form_error('jumlah_keluar', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="total_stok">Total Stok</label>
                    <div class="col-md-5">
                        <div class="input-group">  
                            <input readonly="readonly" id="total_stok" type="number" name="total_stok" class="form-control">
                        </div>  
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="keterangan">Keterangan</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input value="<?= set_value('keterangan'); ?>" name="keterangan" id="keterangan" type="text" class="form-control">
                            </div>
                        </div>
                </div>
                <div class="row form-group">
                    <div class="col offset-md-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<!-- <script src="<?= base_url('assets/') ?>plugins/jquery/jquery.min.js"></script>

<script type="text/javascript">
    
    var stok = $('#stok').val();

    $('#jumlah_keluar').on("input",function() {
        var value = $(this).val();
        var total = parseInt(stok) - parseInt(value);
        // var total = parseInt(value) + parseInt(stok);

        // if(value >= stok){
        //     total = 0;
        // };
        // if(value == 0){
        //     total = stok;
        // };

        $('#stok_k').val(total);
    });
</script> -->