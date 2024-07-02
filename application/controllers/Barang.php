<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
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
        $data['title'] = "Data Barang";
        $q = @$_GET['q'];

        // $data['barang'] = $this->admin->getBarang();
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        // $this->db->order_by('id_barang', 'DESC');
        if ($q) {
            $data['barang'] = $this->db->where('jenis',$q)->get('barang b')->result_array();
        } else {
            $data['barang'] = $this->db->get('barang b')->result_array();
        }

        $this->template->load('templates/admin', 'barang/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('satuan_id', 'Satuan Barang', 'required');
        $this->form_validation->set_rules('jenis', 'Jenis');
    }

    public function add()
    {
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Data Barang";
            $data['satuan'] = $this->admin->get('satuan');
            $jenis = $data['jenis'] = $this->admin->get('jenis');

            // Mengenerate Kode Barang
            // $kode_terakhir = $this->admin->getMax('barang', 'kd_barang');
            // $kode_tambah = substr($kode_terakhir, -6, 6);
            // $kode_tambah++;
            // $kode_baru = str_pad($kode_tambah, 6, '0', STR_PAD_LEFT);
            
            // if($jenis == '1'){
            //     $data['kd_barang'] = 'B' . $kode_baru;
            // }else{
            //     $data['kd_barang'] = 'P' . $kode_baru;
            // }
            
            $this->template->load('templates/admin', 'barang/add', $data);
        } else {

            // $input = $this->input->post(null, true);
            $jenis = $this->input->post('jenis');
            $nama = $this->input->post('nama_barang');
            $satuan = $this->input->post('satuan_id');
            $harga = $this->input->post('harga');

            $id_barang = $this->admin->getMax('barang', 'id_barang');
            $id_barang++;
            

            if($jenis == '1'){
                $kode_terakhir = $this->admin->getMax('barang', 'kd_barang');
                $kode_tambah = substr($kode_terakhir, -6, 6);
                $kode_tambah++;
                $kode_baru = str_pad($kode_tambah, 6, '0', STR_PAD_LEFT);
                $kd = 'B' . $kode_baru;
            }else{
                $kode_terakhir = $this->admin->getMax('barang', 'kd_barang');
                $kode_tambah = substr($kode_terakhir, -6, 6);
                $kode_tambah++;
                $kode_baru = str_pad($kode_tambah, 6, '0', STR_PAD_LEFT);
                $kd = 'P' . $kode_baru;
            }
            
            $input = array(
                'id_barang' => $id_barang,
                'kd_barang' => $kd,
                'nama_barang' => $nama,
                'harga' => $harga,
                'jenis' => $jenis,
                'satuan_id' => $satuan
            );
            $insert = $this->admin->insert('barang', $input);

            if ($insert) {
                set_pesan('data berhasil disimpan');
                redirect('barang');
            } else {
                set_pesan('gagal menyimpan data');
                redirect('barang/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang";
            $data['satuan'] = $this->admin->get('satuan');
            $data['barang'] = $this->admin->get('barang', ['id_barang' => $id]);
            $this->template->load('templates/admin', 'barang/edit', $data);
        } else {

            $nama = $this->input->post('nama_barang');
            $satuan = $this->input->post('satuan_id');
            $harga = $this->input->post('harga');

            $input = array(
                'nama_barang' => $nama,
                'satuan_id' => $satuan,
                'harga' => $harga
            );

            // $input = $this->input->post(null, true);
            $update = $this->admin->update('barang', 'id_barang', $id, $input);

            if ($update) {
                set_pesan('data berhasil diubah');
                redirect('barang');
                // redirect('barang?q='.$id);
            } else {
                set_pesan('gagal mengubah data');
                redirect('barang/edit/' . $id);
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
        redirect('barang');
    }

    public function getstok($getId)
    {
        $id = encode_php_tags($getId);
        $query = $this->admin->cekStok($id);
        output_json($query);
    }

    public function cetak()
    {
        $data['title'] = "Data Barang";
        $q = @$_GET['q'];

        // $data['barang'] = $this->admin->getBarang();
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        $this->db->order_by('jenis');
        $data['barang'] = $this->db->where('jenis',$q)->get('barang b')->result_array();

        $this->load->view('barang/cetak',$data);
    }
}
