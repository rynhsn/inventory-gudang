<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporaninventory extends CI_Controller
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
		$data['title'] = "Laporan Inventory";
		$data['laporan'] = $this->admin->get('report', null, ['category' => 'inventory']);
		$thn = $this->admin->getYearInventory();
		$bln = $this->admin->getMonthInventory();

		//buat array tahun berdasarkan data dari $thn
		$data_tahun = array(); // inisialisasi array kosong untuk menampung hasil query
		foreach ($thn as $row) {
			array_push($data_tahun, $row['tahun']); // memasukkan tahun ke dalam array
		}

		$data['bulan'] = [
			'01' => 'Januari',
			'02' => 'Februari',
			'03' => 'Maret',
			'04' => 'April',
			'05' => 'Mei',
			'06' => 'Juni',
			'07' => 'Juli',
			'08' => 'Agustus',
			'09' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember'
		];
//		foreach ($bln as $bulan) {
//			$bulan = $bulan['bulan'];
//			echo $data['bulan'][$bulan] . "<br>";
//		}
//		die;

		$this->template->load('templates/dashboard', 'laporan/inventory/data', $data);
	}

	public function add(){
		$bulan = $this->input->post('bulan', true);
		$tahun = $this->input->post('tahun', true);

		//validasi
		$cek = $this->admin->get('report', ['bulan' => $bulan, 'tahun' => $tahun]);
		if($cek){
			set_pesan('laporan sudah ada!');
			redirect('laporaninventory');
		}else{
			//generate kode T-LB-YYMMX
			$kode = 'T-LB-' . $tahun . $bulan . 0;

			$data = [
				'id_report' => $kode,
				'month' => $bulan,
				'year' => $tahun,
				'category' => 'inventory',
				'is_verified' => 0, //0 = belum diverifikasi, 1 = sudah diverifikasi
				'verified_at' => null,
				'created_by' => $this->session->userdata('login_session')['user'],
				'created_at' => date('Y-m-d H:i:s')
			];
			$this->admin->insert('report', $data);
			set_pesan('laporan berhasil disimpan.');
			redirect('laporaninventory');
		}
	0-=
}
