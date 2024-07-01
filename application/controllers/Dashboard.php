<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
    }

    public function index()
    {
        $data['title'] = "Dashboard";
        $data['barang'] = $this->admin->count('barang');
        $data['barang_masuk'] = $this->admin->count('barang_masuk');
        $data['barang_keluar'] = $this->admin->count('barang_keluar');
        $data['keluar_harian'] = $this->admin->count('keluar_harian');
        $data['supplier'] = $this->admin->count('supplier');
        $data['user'] = $this->admin->count('user');
        $data['stok'] = $this->admin->sum('barang', 'stok');
        $data['transaksi'] = [
            'barang_masuk' => $this->admin->getBarangMasuk(10),
            'barang_keluar' => $this->admin->getBarangKeluar(10),
            'keluar_harian' => $this->admin->getKeluarharian(10),
            'total' => $this->admin->getBarang(10)
        ]; 

        $data['periode'] = $this->db->order_by('dari','DESC')->get('periode')->row();

        // $data['modal'] = $this->db->query("SELECT SUM(nominal) as nominal FROM keuangan WHERE jenis='Modal' ")->row();
        // $data['pengeluaran'] = $this->db->query("SELECT SUM(nominal) as nominal FROM keuangan WHERE jenis='Pengeluaran' ")->row();
        // $data['pemasukan'] = $this->db->query("SELECT SUM(nominal) as nominal FROM keuangan WHERE jenis='Pemasukan' ")->row();
        // $data['laba'] = $data['modal']->nominal-$data['pengeluaran']->nominal+$data['pemasukan']->nominal;

        // Line Chart
        $bln = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $data['cbm'] = [];
        $data['cbk'] = [];
        $year = date('Y');
        $dari = $data['periode']->dari;
        $sampai = $data['periode']->sampai;

        foreach ($bln as $b) {
            if ($b == date('m',strtotime($dari))) {
                $this->db->where("tanggal_masuk BETWEEN '$dari' AND '$sampai'");
                $data['cbm'][] = $this->db->select("SUM(jumlah_masuk) as count")->where('barang_id','P000000')->get('hasil_produksi')->row()->count;
            }
            
            if (date('m',strtotime($dari)) OR date('m',strtotime($dari))) {
                if ($b == date('m',strtotime($sampai))) {
                    $this->db->where("tanggal_masuk BETWEEN '$dari' AND '$sampai'");
                    $data['cbm'][] = $this->db->select("SUM(jumlah_masuk) as count")->where('barang_id','P000000')->get('hasil_produksi')->row()->count;
                }
            }

            // $data['cbm'][] = $this->admin->chartBarangMasuk($b);
            // $data['cbk'][] = $this->admin->chartBarangKeluar($b);

            // $this->db->where("YEAR(tanggal_keluar)='$year' AND MONTH(tanggal_keluar)='$b'");
            // $data['cbk'][] = $this->db->select("SUM(jumlah_keluar) as count")->get('barang_keluar')->row()->count;
        }


        $this->template->load('templates/admin', 'dashboard', $data);
    }

    public function periode() {
        if ($_POST['action'] == "update") {
            $get = $this->db->order_by('dari','DESC')->get('periode')->row();

            $update = [
                'dari' => $_POST['dari'],
                'sampai' => $_POST['sampai'],
                'status' => ''
            ];

            $this->db->where('id',$get->id);
            $this->db->update('periode',$update);

            redirect('dashboard');
        } else {
            $insert = [
                'dari' => $_POST['dari'],
                'sampai' => $_POST['sampai'],
                'status' => ''
            ];

            $this->db->insert('periode',$insert);
        }

        redirect('dashboard');
    }
}
