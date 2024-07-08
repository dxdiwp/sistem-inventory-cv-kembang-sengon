<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hasilproduksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = "Data Hasil Produksi";
    
        $this->db->select('*');
        $this->db->join('user u', 'hp.user_id = u.id_user');
        $this->db->join('barang b', 'hp.barang_id = b.id_barang');
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        $this->db->order_by('id_hasil_produksi');
        $this->db->where('b.jenis', '2');
    
        if (@$_GET['periode']) {
            $per = $this->db->query("SELECT * FROM periode WHERE id=$_GET[periode]")->result();
            $dari = $per[0]->dari;
            $sampai = $per[0]->sampai;
            $this->db->where("tanggal_masuk BETWEEN '$dari' AND '$sampai' ");
        }
        $data['keluarharian'] = $this->db->get('hasil_produksi hp')->result_array();

    
        // Query untuk keluaran pakan
        // $this->db->select('*');
        // $this->db->join('user u', 'hp.user_id = u.id_user');
        // $this->db->join('barang b', 'hp.barang_id = b.id_barang');
        // $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        // $this->db->order_by('id_hasil_produksi', 'DESC');
        // $this->db->where('b.jenis', '2');
        // $data['keluarharianpakan'] = $this->db->get('hasil_produksi hp')->result_array();
    
        $data['periode'] = $this->db->get('periode')->result();
    
        // Jika tombol cetak ditekan
        if ($this->input->get('cetak')) {
            // Load tampilan cetak
            $this->load->view('hasil_produksi/cetak', $data);
            return; // Hentikan eksekusi agar hanya menampilkan tampilan cetak
        }
    
        $this->template->load('templates/admin', 'hasil_produksi/data', $data);
    }
    
    private function _validasi()
    {
        $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required|trim');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');

        $input = @$this->input->post('barang_id', true);
        $stok = @$this->admin->get('barang', ['id_barang' => $input])['stok'];
        $stok_valid = $stok + 1;

        $this->form_validation->set_rules(
            'jumlah_masuk',
            'Jumlah Masuk',
            // "required|trim|numeric|greater_than[0]|less_than[{$stok_valid}]",
            "required|trim|numeric|greater_than[0]",
            [
                'greater_than' => "Jumlah Masuk tidak boleh kosong"
            ]
        );
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Data Hasil Produksi";
            $data['barang'] = $this->admin->get('barang', null, ['jenis' => '2']);

            // Mendapatkan dan men-generate kode transaksi barang keluar
            $kode = 'HP-';
            $kode_terakhir = $this->admin->getMax('hasil_produksi', 'kd_hasil_produksi', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $data['kd_hasil_produksi'] = $kode . $number;

            $this->template->load('templates/admin', 'hasil_produksi/add', $data);
        } else {

            // $id_produksi = $this->admin->getMax('hasil_produksi', 'id_hasil_produksi');
            // $id_produksi++;

            $kode = 'HP-';
            $kode_terakhir = $this->admin->getMax('hasil_produksi', 'kd_hasil_produksi', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT); 
            $kd_produksi = $kode . $number;           

            // $tgl_produksi = $this->admin->post('tanggal');
            $tgl_produksi = $this->input->post('tanggal_masuk');
            $barang = $this->input->post('barang_id');
            $qty = $this->input->post('jumlah_masuk');
            $stok = $this->input->post('total_stok');
            $ket = $this->input->post('keterangan');
            

            $input = array(
                'kd_hasil_produksi' => $kd_produksi,
                'user_id' => $this->session->userdata('login_session')['user'],
                'barang_id' => $barang,
                'jumlah_masuk' => $qty,
                'stok_k' => $stok,
                'tanggal_masuk' => $tgl_produksi,
                'keterangan' => $ket
            );

            // $input = $this->input->post();
            $insert = $this->db->insert('hasil_produksi', $input);
            $this->db->set('stok', $stok, FALSE);
            $this->db->where('id_barang',$input['barang_id']);
            $this->db->update('barang');

            set_pesan('data berhasil disimpan.');
            redirect('hasilproduksi');
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('hasil_produksi', 'id_hasil_produksi', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('hasilproduksi');
    }

    public function cetak() {
        $data['title'] = "Data Hasil Produksi";
    
        $this->db->select('*');
        $this->db->join('user u', 'kh.user_id = u.id_user');
        $this->db->join('barang b', 'kh.barang_id = b.id_barang');
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        $this->db->order_by('id_hasil_produksi');
    
        if (@$_GET['periode']) {
            $per = $this->db->query("SELECT * FROM periode WHERE id=$_GET[periode]")->result();
            $dari = $per[0]->dari;
            $sampai = $per[0]->sampai;
            $this->db->where("tanggal_masuk BETWEEN '$dari' AND '$sampai' ");
        }
    
        $data['keluarharian'] = $this->db->get('hasil_produksi kh')->result_array();

    
        // Query untuk keluaran pakan
        // $this->db->select('*');
        // $this->db->join('user u', 'kh.user_id = u.id_user');
        // $this->db->join('barang b', 'kh.barang_id = b.id_barang');
        // $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        // $this->db->order_by('id_hasil_produksi', 'DESC');
        // $data['keluarharianpakan'] = $this->db->get('hasil_produksi kh')->result_array();
    
        $data['periode'] = $this->db->get('periode')->result();
    
        $this->load->view('hasil_produksi/cetak',$data);
    }
}
