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
        $data['barang_masuk'] = $this->admin->sum('barang_masuk', 'jumlah_masuk');
        $data['barang_keluar'] = $this->admin->sum('barang_keluar', 'jumlah_keluar');
        $data['barang_rusak'] = $this->admin->sum('barang_rusak', 'jumlah_rusak');
        $data['barang_hilang'] = $this->admin->sum('barang_hilang', 'jumlah_hilang');
        $data['supplier'] = $this->admin->count('supplier');
        $data['user'] = $this->admin->count('user');
        $data['stok'] = $this->admin->sum('barang', 'stok');
        $data['barang_min'] = $this->admin->min('barang', 'stok', 10);
        $data['transaksi'] = [
            'barang_masuk' => $this->admin->getBarangMasuk(5),
            'barang_keluar' => $this->admin->getBarangKeluar(5),
            'barang_rusak' => $this->admin->getBarangRusak(5),
            'barang_hilang' => $this->admin->getBarangHilang(5)
        ];
		$data['ranking'] = [
			'barang_masuk_top' => $this->admin->rankingBarang('masuk', 5, 'top'),
			'barang_masuk_bottom' => $this->admin->rankingBarang('masuk', 5, 'bottom'),
			'barang_keluar_top' => $this->admin->rankingBarang('keluar', 5, 'top'),
			'barang_keluar_bottom' => $this->admin->rankingBarang('keluar', 5, 'bottom'),
		];

        // Line Chart
        $bln = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $data['cbm'] = [];
        $data['cbk'] = [];
        $data['cbr'] = [];
        $data['cbh'] = [];

        foreach ($bln as $b) {
            $data['cbm'][] = $this->admin->chartBarangMasuk($b);
            $data['cbk'][] = $this->admin->chartBarangKeluar($b);
            $data['cbr'][] = $this->admin->chartBarangRusak($b);
            $data['cbh'][] = $this->admin->chartBarangHilang($b);
        }



        $this->template->load('templates/dashboard', 'dashboard', $data);
    }
}
