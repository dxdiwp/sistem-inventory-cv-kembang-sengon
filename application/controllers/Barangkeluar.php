<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barangkeluar extends CI_Controller
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
        $data['title'] = "Data Penjualan";

        $this->db->select('*');
        $this->db->join('user u', 'bk.user_id = u.id_user');
        $this->db->join('barang b', 'bk.barang_id = b.id_barang');
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        // $this->db->order_by('id_barang_keluar', 'DESC');
        $this->db->where('b.jenis', '2');

        if (@$_GET['periode']) {
            $per = $this->db->query("SELECT * FROM periode WHERE id=$_GET[periode]")->result();
            $dari = $per[0]->dari;
            $sampai = $per[0]->sampai;
            $this->db->where("bk.tanggal_keluar BETWEEN '$dari' AND '$sampai' ");
        }

        $data['barangkeluar'] = $this->db->get('barang_keluar bk')->result_array();

        $data['periode'] = $this->db->get('periode')->result();

        $this->template->load('templates/admin', 'barang_keluar/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('tanggal_keluar', 'Tanggal Keluar', 'required|trim');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');

        $input = $this->input->post('barang_id', true);
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
            $data['title'] = "Data Penjualan";
            // $data['barang'] = $this->db->get_where('barang', null, ['jenis'=>'2'])->result_array();
            $data['barang'] = $this->db->get_where('barang',['jenis'=>'2'])->result_array();

            // Mendapatkan dan men-generate kode transaksi barang keluar
            $kode = 'PA-' ;
            $kode_terakhir = $this->admin->getMax('barang_keluar', 'kd_barang_keluar', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $data['kd_barang_keluar'] = $kode . $number;

            $this->template->load('templates/admin', 'barang_keluar/add', $data);
        } else {

            $id_barang_keluar = $this->admin->getMax('barang_keluar', 'id_barang_keluar');
            $id_barang_keluar++;

            $kode = 'PA-' ;
            $kode_terakhir = $this->admin->getMax('barang_keluar', 'kd_barang_keluar', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $kd_barang_keluar = $kode . $number;

            $barang = $this->input->post('barang_id');
            $jumlah_keluar = $this->input->post('jumlah_keluar');
            $harga = NULL;
            $tgl_keluar = $this->input->post('tanggal_keluar');
            $nama = $this->input->post('nama_pembeli');
            $alamat = $this->input->post('alamat_pembeli');

            $input = array(
                'id_barang_keluar' => $id_barang_keluar,
                'kd_barang_keluar' => $kd_barang_keluar,
                'barang_id' => $barang,
                'user_id' => $this->session->userdata('login_session')['user'],
                'jumlah_keluar' => $jumlah_keluar,
                'tanggal_keluar' => $tgl_keluar,
                'nama_pembeli' => $nama,
                'alamat_pembeli' => $alamat
            );

            // $input = $this->input->post(null, true);
            $insert = $this->db->insert('barang_keluar',$input);
            // var_dump($input);die;
            // $insert = $this->admin->insert('barang_keluar', $input);

            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('barangkeluar');
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('barangkeluar/add');
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('barang_keluar', 'id_barang_keluar', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('barangkeluar');
    }

    public function cetak()
    {
        $this->db->select('*');
        $this->db->join('user u', 'bk.user_id = u.id_user');
        $this->db->join('barang b', 'bk.barang_id = b.id_barang');
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        // $this->db->order_by('id_barang_keluar', 'DESC');

        if (@$_GET['periode']) {
            $per = $this->db->query("SELECT * FROM periode WHERE id=$_GET[periode]")->result();
            $dari = $per[0]->dari;
            $sampai = $per[0]->sampai;
            $this->db->where("bk.tanggal_keluar BETWEEN '$dari' AND '$sampai' ");
        }

        $data['barangkeluar'] = $this->db->get('barang_keluar bk')->result_array();

        $this->load->view('barang_keluar/cetak',$data);
    }

    public function invoice($id)
    {
        $this->db->select('*');
        $this->db->join('user u', 'bk.user_id = u.id_user');
        $this->db->join('barang b', 'bk.barang_id = b.id_barang');
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        $this->db->where('id_barang_keluar', $id);

        if (@$_GET['periode']) {
            $per = $this->db->query("SELECT * FROM periode WHERE id=$_GET[periode]")->result();
            $dari = $per[0]->dari;
            $sampai = $per[0]->sampai;
            $this->db->where("bk.tanggal_keluar BETWEEN '$dari' AND '$sampai' ");
        }

        $data['row'] = $this->db->get('barang_keluar bk')->row();

        $this->load->view('barang_keluar/invoice',$data);
    }
}

