<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bahanbaku extends CI_Controller
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
        $data['title'] = "Data Bahan Baku";
        $data['barang'] = $this->admin->getBarang();
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        $this->db->order_by('id_barang');
        $data['barang'] = $this->db->where('jenis', '1')->get('barang b')->result_array();

        $this->template->load('templates/admin', 'barang/b_baku', $data);   
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('satuan_id', 'Satuan Barang', 'required');
        // $this->form_validation->set_rules('jenis', 'Jenis');
    }
    public function add()
    {
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Data Barang";
            $data['satuan'] = $this->admin->get('satuan');
            $data['jenis'] = $this->admin->get('jenis');

            // Mengenerate Kode Barang
            $kode_terakhir = $this->admin->getMax('barang', 'kd_b_baku');
            $kode_tambah = substr($kode_terakhir, -6, 6);
            $kode_tambah++;
            $kode_baru = str_pad($kode_tambah, 6, '0', STR_PAD_LEFT);
            $data['bahanbaku'] = 'BB-' . $kode_baru;
        

            $this->template->load('templates/admin', 'barang/add_b_baku', $data);
        } else {

            $input = $this->input->post(null, true);

            $insert = $this->admin->insert('barang', $input);

            if ($insert) {
                set_pesan('data berhasil disimpan');
                redirect('bahanbaku');
            } else {
                set_pesan('gagal menyimpan data');
                redirect('bahanbaku/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Bahan Baku";
            $data['satuan'] = $this->admin->get('satuan');
            $data['barang'] = $this->admin->get('barang', ['id_barang' => $id]);
            $this->template->load('templates/admin', 'barang/edit_b_baku', $data);
        } else {

            $input = $this->input->post(null, true);
            $update = $this->admin->update('barang', 'id_barang', $id, $input);

            if ($update) {
                set_pesan('data berhasil diubah');
                redirect('bahanbaku');
            } else {
                set_pesan('gagal mengubah data');
                redirect('bahanbaku/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('barang', 'id_barang', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('bahanbaku');
    }

    public function cetak()
    {
        $data['title'] = "Data Bahan Baku";
        // $q = @$_GET['q'];

        // $data['barang'] = $this->admin->getBarang();
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        $this->db->order_by('id_barang');
        $data['barang'] = $this->db->where('jenis',1)->get('barang b')->result_array();

        $this->load->view('barang/cetak_b_baku',$data);
    }
}