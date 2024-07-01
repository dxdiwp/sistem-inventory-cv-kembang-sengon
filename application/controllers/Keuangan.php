<?php
defined ('BASEPATH') or exit('No direct script access allowed');

class Keuangan extends CI_Controller
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
        $tgl_mulai = $this->input->get('tgl_mulai');
        $tgl_selesai = $this->input->get('tgl_selesai');
        // $cari = $this->input->post('cari');

        // $tgl_mulai = strtotime($tgl_mulai);
        // $tgl_selesai = strtotime($tgl_selesai);
        // $bruh = $this->input->get(array($tgl_mulai,$tgl_selesai), true);
        // $a = date('Y-m-d', $tgl_selesai);

        if (@$_GET['periode']) {
            $per = $this->db->query("SELECT * FROM periode WHERE id=$_GET[periode]")->result();
            $dari = $per[0]->dari;
            $sampai = $per[0]->sampai;
            $this->db->where("tgl BETWEEN '$dari' AND '$sampai' ");
        }

        if (@$_GET['jenis']){
            if (@$_GET['jenis'] != "Semua") {
                $this->db->where("jenis",@$_GET['jenis']);
            }
        }

        

        $data['keuangan'] = $this->db->order_by('tgl')->get('keuangan')->result_array();
        // $this->admin->get('keuangan', '', 'tgl BETWEEN "'. $tgl_mulai . '" and "'.  $tgl_selesai.'"' );


        $data['periode'] = $this->db->get('periode')->result();
        // if (@$_GET['cari'] == 'cetak') {
        //     $this->load->view('keuangan/cetak',$data);
        // } else {
            if(@$_GET['cari'] === 'cetak'){
                // $as = 'haduh';
                // var_dump($as);
                // $tgl_mulai = $this->input->post($tgl_mulai, true);
                // $tgl_selesai = $this->input->post($tgl_selesai, true);
                $this->load->view('keuangan/cetak',$data);
                
            }else{
                // $as = '';
                // var_dump($as);
                $data['title'] = "Keuangan";
                // $data['keuangan'] = $this->admin->get('keuangan');
                $this->template->load('templates/admin', 'keuangan/data', $data);
                
            }
        
        // }

        // $input = $this->input->post(null, true);

        // $data['title'] = "Keuangan";
        // $data['keuangan'] = $this->admin->get('keuangan', $input, 'tgl BETWEEN "'. '2024-01-03' . '" and "'. '2024-01-19'.'"');
        // $this->template->load('templates/admin', 'keuangan/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('tgl', 'Tanggal', 'required|trim');
        $this->form_validation->set_rules('jenis', 'Jenis', 'required|trim');
        $this->form_validation->set_rules('nominal', 'Harga', 'required|trim');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required|trim');
        // $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'required|trim');
        // $this->form_validation->set_rules('tgl_selesai', 'Tanggal Selesai', 'required|trim');

    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Keuangan";
            $this->template->load('templates/admin', 'keuangan/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $save = $this->admin->insert('keuangan', $input);
            if ($save) {
                set_pesan('data berhasil disimpan.');
                redirect('keuangan');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('keuangan/add');
            }
        }
    }


    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Keuangan";
            $data['keuangan'] = $this->admin->get('keuangan', ['id_keuangan' => $id]);
            $this->template->load('templates/admin', 'keuangan/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->admin->update('keuangan', 'id_keuangan', $id, $input);

            if ($update) {
                set_pesan('data berhasil diedit.');
                redirect('keuangan');
            } else {
                set_pesan('data gagal diedit.');
                redirect('keuangan/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('keuangan', 'id_keuangan', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('keuangan');
    }

    public function cari()
    {
        // $tanggala = encode_php_tags($tanggal);
        $this->_validasi();


        if ($this->form_validation->run() == false) {
            $data['title'] = "Keuangan";
            $data['keuangan'] = $this->admin->get('keuangan', '', 'tgl BETWEEN "' . '2024-01-03' . '" and "' . '2024-01-19' . '"');
            $this->template->load('templates/admin', 'keuangan/data', $data);
        } else {
            echo "Tidak ada data";
        }
    }
}
