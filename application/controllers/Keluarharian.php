<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keluarharian extends CI_Controller
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
        $data['title'] = "Data Pengeluaran";
    
        $this->db->select('*');
        $this->db->join('user u', 'kh.user_id = u.id_user');
        $this->db->join('barang b', 'kh.barang_id = b.id_barang');
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        $this->db->order_by('id_keluar_harian');
        $this->db->where('b.jenis', '1');
    
        if (@$_GET['periode']) {
            $per = $this->db->query("SELECT * FROM periode WHERE id=$_GET[periode]")->result();
            $dari = $per[0]->dari;
            $sampai = $per[0]->sampai;
            $this->db->where("tanggal_keluar BETWEEN '$dari' AND '$sampai' ");
        }
    
        $data['keluarharian'] = $this->db->get('keluar_harian kh')->result_array();
    
        // Query untuk keluaran pakan
        // $this->db->select('*');
        // $this->db->join('user u', 'kh.user_id = u.id_user');
        // $this->db->join('barang b', 'kh.barang_id = b.id_barang');
        // $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        // $this->db->order_by('id_keluar_harian', 'DESC');
        // $this->db->where('b.jenis', '1');
        // $data['keluarharianpakan'] = $this->db->get('keluar_harian kh')->result_array();
    
        $data['periode'] = $this->db->get('periode')->result();
    
        // Jika tombol cetak ditekan
        if ($this->input->get('cetak')) {
            // Load tampilan cetak
            $this->load->view('keluar_harian/cetak', $data);
            return; // Hentikan eksekusi agar hanya menampilkan tampilan cetak
        }
    
        $this->template->load('templates/admin', 'keluar_harian/data', $data);
    }
    
    private function _validasi()
    {
        $this->form_validation->set_rules('tanggal_keluar', 'Tanggal Keluar', 'required|trim');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');

        $input = @$this->input->post('barang_id', true);
        $stok = @$this->admin->get('barang', ['id_barang' => $input])['stok'];
        $stok_valid = $stok + 1;

        $this->form_validation->set_rules(
            'jumlah_keluar',
            'Jumlah Keluar',
            "required|trim|numeric|greater_than[0]|less_than[{$stok_valid}]",
            [
                'less_than' => "Jumlah Keluar tidak boleh lebih dari {$stok}"
            ]
        );
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Data Pengeluaran";
            $data['barang'] = $this->admin->get('barang', null, ['jenis'=>'1']);

            // Mendapatkan dan men-generate kode transaksi barang keluar
            $kode = 'KH-';
            $kode_terakhir = $this->admin->getMax('keluar_harian', 'kd_keluar_harian', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $data['kd_keluar_harian'] = $kode . $number;

            $this->template->load('templates/admin', 'keluar_harian/add', $data);
        } else {
            // $input = $this->input->post(null, true);

            $id_keluar_harian = $this->admin->getMax('keluar_harian', 'id_keluar_harian');
            $id_keluar_harian++;

            $tgl_keluar = $this->input->post('tanggal_keluar');
            $barang = $this->input->post('barang_id');
            $qty = $this->input->post('jumlah_keluar');
            $stok = $this->input->post('stok_k');
            $ket = $this->input->post('keterangan');

            $kode = 'KH-';
            $kode_terakhir = $this->admin->getMax('keluar_harian', 'kd_keluar_harian', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $kd_keluar_harian = $kode . $number;

            $input =array(
                'id_keluar_harian' => $id_keluar_harian,
                'kd_keluar_harian' => $kd_keluar_harian,
                'user_id' => $this->session->userdata('login_session')['user'],
                'barang_id' => $barang,
                'jumlah_keluar' => $qty,
                'stok_k' => $stok,
                'tanggal_keluar' => $tgl_keluar,
                'keterangan' => $ket
            );

            $insert = $this->admin->insert('keluar_harian', $input);

            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('keluarharian');
            } else {
                set_pesan('Oops ada kesalahan!');
                redirect('keluarharian/add');
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('keluar_harian', 'id_keluar_harian', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('keluarharian');
    }

    public function cetak() {
        $data['title'] = "Data Pengeluaran";
    
        $this->db->select('*');
        $this->db->join('user u', 'kh.user_id = u.id_user');
        $this->db->join('barang b', 'kh.barang_id = b.id_barang');
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        $this->db->order_by('id_keluar_harian');
        $this->db->where('b.jenis', '1');
    
        if (@$_GET['periode']) {
            $per = $this->db->query("SELECT * FROM periode WHERE id=$_GET[periode]")->result();
            $dari = $per[0]->dari;
            $sampai = $per[0]->sampai;
            $this->db->where("tanggal_keluar BETWEEN '$dari' AND '$sampai' ");
        }
    
        $data['keluarharian'] = $this->db->get('keluar_harian kh')->result_array();
    
        // Query untuk keluaran pakan
        // $this->db->select('*');
        // $this->db->join('user u', 'kh.user_id = u.id_user');
        // $this->db->join('barang b', 'kh.barang_id = b.id_barang');
        // $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        // $this->db->order_by('id_keluar_harian', 'DESC');
        // $this->db->where('barang_id', 'B000001');
        // $data['keluarharianpakan'] = $this->db->get('keluar_harian kh')->result_array();
    
        $data['periode'] = $this->db->get('periode')->result();
    
        // Jika tombol cetak ditekan
        if ($this->input->get('cetak')) {
            // Load tampilan cetak
            $this->load->view('keluar_harian/cetak', $data);
            return; // Hentikan eksekusi agar hanya menampilkan tampilan cetak
        }
    
        $this->load->view('keluar_harian/cetak',$data);
    }
}
