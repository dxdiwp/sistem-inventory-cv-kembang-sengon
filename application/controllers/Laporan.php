<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
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
        $this->form_validation->set_rules('transaksi', 'Transaksi', 'required|in_list[barang_masuk,barang_keluar,keluar_harian]');
        $this->form_validation->set_rules('tanggal', 'Periode Tanggal', 'required');

        if ($this->form_validation->run() == false) {
            $data['title'] = "Laporan ";
            $this->template->load('templates/admin', 'laporan/form', $data);
        } else {
            $input = $this->input->post(null, true);
            $table = $input['transaksi'];
            $tanggal = $input['tanggal_masuk'];
            $pecah = explode(' - ', $tanggal);
            $mulai = date('Y-m-d', strtotime($pecah[0]));
            $akhir = date('Y-m-d', strtotime(end($pecah)));

            $query = '';
            if ($table == 'barang_masuk') {
                $query = $this->admin->getBarangMasuk(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
            } elseif ($table == 'barang_keluar') {
                $query = $this->admin->getBarangKeluar(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
            }else {
                $query = $this->admin->getHasilProduksi(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
            }

            $this->_cetak($query, $table, $tanggal);
        }
    }

    private function _cetak($data, $table_, $tanggal)
    {
        $this->load->library('CustomPDF');
        $table = $table_ == 'barang_masuk' ? 'Pembelian' : 'Pengeluaran'   ;

        $pdf = new FPDF();
        $pdf->AddPage('P', 'Letter');
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(190, 7, 'Laporan ' . $table, 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(190, 4, 'Tanggal : ' . $tanggal, 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 10);

        if ($table_ == 'barang_masuk') :
            $pdf->Cell(16, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(20, 7, 'Tgl Masuk', 1, 0, 'C');
            $pdf->Cell(20, 7, 'ID Transaksi', 1, 0, 'C');
            $pdf->Cell(35, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(35, 7, 'Supplier', 1, 0, 'C');
            $pdf->Cell(35, 7, 'Jumlah Masuk', 1, 0, 'C');
            $pdf->Cell(20, 7, 'Harga', 1, 0, 'C');
            $pdf->Cell(20, 7, 'Subtotal', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            $total = 0;
            foreach ($data as $d) {
                $total += $d['jumlah_masuk']*$d['harga'];

                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(16, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(20, 7, $d['tanggal_masuk'], 1, 0, 'C');
                $pdf->Cell(20, 7, $d['id_barang_masuk'], 1, 0, 'C');
                $pdf->Cell(35, 7, $d['nama_barang'], 1, 0, 'L');
                $pdf->Cell(35, 7, $d['nama_supplier'], 1, 0, 'L');
                $pdf->Cell(35, 7, $d['jumlah_masuk'] . ' ' . $d['nama_satuan'], 1, 0, 'C');
                $pdf->Cell(20, 7, number_format($d['harga']), 1, 0, 'L');
                $pdf->Cell(20, 7, number_format($d['jumlah_masuk']*$d['harga']), 1, 0, 'L');
                $pdf->Ln();
            } 

            $pdf->Cell(16, 7, '', 1, 0, 'C');
            $pdf->Cell(20, 7, '', 1, 0, 'C');
            $pdf->Cell(20, 7, '', 1, 0, 'C');
            $pdf->Cell(35, 7, '', 1, 0, 'C');
            $pdf->Cell(35, 7, '', 1, 0, 'C');
            $pdf->Cell(35, 7, '', 1, 0, 'C');
            $pdf->Cell(20, 7, '', 1, 0, 'C');
            $pdf->Cell(20, 7, number_format($total), 1, 0, 'L');
            $pdf->Ln();

            elseif ($table_ == 'barang_keluar') :
            $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(25, 7, 'Tanggal', 1, 0, 'C');
            $pdf->Cell(20, 7, 'Penjualan', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Nama Pembeli', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Alamat', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Jumlah', 1, 0, 'C');
            $pdf->Cell(25, 7, 'Harga', 1, 0, 'C');
            $pdf->Cell(25, 7, 'Subtotal', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data as $d) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(25, 7, $d['tanggal_keluar'], 1, 0, 'C');
                $pdf->Cell(20, 7, $d['nama_barang'], 1, 0, 'L');
                $pdf->Cell(30, 7, $d['nama_pembeli'], 1, 0, 'C');
                $pdf->Cell(30, 7, $d['alamat_pembeli'], 1, 0, 'C');
                $pdf->Cell(30, 7, $d['jumlah_keluar'] . ' ' . $d['nama_satuan'], 1, 0, 'C');
                $pdf->Cell(25, 7, number_format($d['harga']), 1, 0, 'C');
                $pdf->Cell(25, 7, number_format($d['harga']*$d['jumlah_keluar']), 1, 0, 'C');
                $pdf->Ln();
            } 
            else :
            $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(40, 7, 'Tanggal', 1, 0, 'C');
            $pdf->Cell(45, 7, 'Nama Barang', 1, 0, 'C');
            // $pdf->Cell(60, 7, 'Keterangan', 1, 0, 'C');
            $pdf->Cell(50, 7, 'Jumlah Masuk', 1, 0, 'C');
            $pdf->Cell(50, 7, 'Sisa', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data as $d) {
                
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(40, 7, $d['tanggal'], 1, 0, 'C');
                $pdf->Cell(45, 7, $d['nama_barang'], 1, 0, 'L');
                // $pdf->Cell(60, 7, $d['keterangan'], 1, 0, 'C');
                $pdf->Cell(50, 7, $d['jumlah_masuk'] . ' ' . $d['nama_satuan'], 1, 0, 'C');
                $pdf->Cell(50, 7, $d['stok_k']. ' ' . $d['nama_satuan'], 1, 0, 'C');
                $pdf->Ln();
                
            }
                
                // $pdf->Cell(135, 7, 'Total Keluar', 1, 0, 'C');
                // $pdf->SetFont('Arial', '', 10);
                // $pdf->Ln();
                   
             
         
        endif;

        $pdf->Ln(16);
        $pdf->Ln(16);

        $pdf->SetFont('Arial','B',10);
        $pdf->SetX(1);
        $pdf->MultiCell(310,2,'Diketahui Oleh',0,'C');
        $pdf->Ln(18);
        

        $pdf->SetFont('Arial','B',10);
        $pdf->SetX(1);
        $pdf->MultiCell(50,0.5,'',0,'C');

        $pdf->SetFont('Arial','B',10);
        $pdf->SetX(1);
        $pdf->MultiCell(310,0.8,'( Peternak )',0,'C');

        $pdf->Ln();


     

        $file_name = $table . ' ' . $tanggal;
        $pdf->Output('I', $file_name);
    }
}
