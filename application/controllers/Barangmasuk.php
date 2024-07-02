<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barangmasuk extends CI_Controller
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
        $data['title'] = "Data Pembelian";

        $this->db->select('*');
        $this->db->join('user u', 'bm.user_id = u.id_user');
        $this->db->join('supplier sp', 'bm.supplier_id = sp.id_supplier');
        $this->db->join('barang b', 'bm.barang_id = b.id_barang');
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        // $this->db->order_by('id_barang_masuk', 'DESC');
        $this->db->where('b.jenis', '1');

        if (@$_GET['periode']) {
            $per = $this->db->query("SELECT * FROM periode WHERE id=$_GET[periode]")->result();
            $dari = $per[0]->dari;
            $sampai = $per[0]->sampai;
            $this->db->where("bm.tanggal_masuk BETWEEN '$dari' AND '$sampai' ");
        }

        $data['barangmasuk'] = $this->db->get('barang_masuk bm')->result_array();

        // $this->db->select('*');
        // $this->db->join('user u', 'bm.user_id = u.id_user');
        // $this->db->join('barang b', 'bm.barang_id = b.id_barang');
        // $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        // $this->db->join('supplier sp', 'bm.supplier_id = sp.id_supplier');
        // // $this->db->order_by('id_barang_masuk', 'DESC');
        // $this->db->where('b.jenis', '1');

        // if (@$_GET['periode']) {
        //     $per = $this->db->query("SELECT * FROM periode WHERE id=$_GET[periode]")->result();
        //     $dari = $per[0]->dari;
        //     $sampai = $per[0]->sampai;
        //     $this->db->where("bm.tanggal_masuk BETWEEN '$dari' AND '$sampai' ");
        // }

        // $data['barangmasukayam'] = $this->db->get('barang_masuk bm')->result_array();
        

        $data['periode'] = $this->db->get('periode')->result();

        $this->template->load('templates/admin', 'barang_masuk/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required|trim');
        $this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');
        $this->form_validation->set_rules('jumlah_masuk', 'Jumlah Masuk', 'required|trim|numeric|greater_than[0]');
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Data Pembelian";
            $data['supplier'] = $this->admin->get('supplier');
            $data['barang'] = $this->db->get_where('barang',['jenis'=>'1'])->result_array();
            // $data['barang'] = $this->admin->get('barang');

            // Mendapatkan dan men-generate kode transaksi barang masuk
            $kode = 'PB-';
            $kode_terakhir = $this->admin->getMax('barang_masuk', 'kd_barang_masuk', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $data['kd_barang_masuk'] = $kode . $number;

            // $id = $this->admin->getMax('barang_masuk', 'id_barang_masuk');
            // $id++;  

            $this->template->load('templates/admin', 'barang_masuk/add', $data);
        } else {

            // $input = $this->input->post(null, true);
            // $id_user = $this->session;
            // $id_trx = $this->input->post('kd_barang_masuk');
            $tgl_masuk = $this->input->post('tanggal_masuk');
            $supplier = $this->input->post('supplier_id');
            $barang = $this->input->post('barang_id');
            // $stok = $this->input->post('stok');
            $harga = $this->input->post('harga');
            $qty = $this->input->post('jumlah_masuk');

            $id_barang_masuk = $this->admin->getMax('barang_masuk', 'id_barang_masuk');
            $id_barang_masuk++;

            $kode = 'PB-';
            $kode_terakhir = $this->admin->getMax('barang_masuk', 'kd_barang_masuk', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $kd_barang_masuk = $kode . $number;

            $input = array(
                'id_barang_masuk' => $id_barang_masuk,
                'kd_barang_masuk' => $kd_barang_masuk,
                'supplier_id' => $supplier,
                // 'user_id' => $this->session->id_user,
                'user_id' => $this->session->userdata('login_session')['user'],
                 'barang_id' => $barang,
                'jumlah_masuk' => $qty,
                'harga' => $harga,
                'tanggal_masuk' => $tgl_masuk 
            );

            $insert = $this->admin->insert('barang_masuk', $input);

            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('barangmasuk');
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('barangmasuk/add');
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('barang_masuk', 'id_barang_masuk', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('barangmasuk');
    }

    public function cetak()
    {
        $this->db->select('*');
        $this->db->join('user u', 'bm.user_id = u.id_user');
        $this->db->join('barang b', 'bm.barang_id = b.id_barang');
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        $this->db->join('supplier sp', 'bm.supplier_id = sp.id_supplier');
        // $this->db->order_by('id_barang_masuk', 'DESC');
        $this->db->where('b.jenis', '1');

        if (@$_GET['periode']) {
            $per = $this->db->query("SELECT * FROM periode WHERE id=$_GET[periode]")->result();
            $dari = $per[0]->dari;
            $sampai = $per[0]->sampai;
            $this->db->where("bm.tanggal_masuk BETWEEN '$dari' AND '$sampai' ");
        }

        $data['barangmasuk'] = $this->db->get('barang_masuk bm')->result_array();

        $this->load->view('barang_masuk/cetak',$data);
    }

}
