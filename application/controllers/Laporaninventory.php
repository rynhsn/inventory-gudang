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
//		userdata('role');
		$data['title'] = "Laporan Inventory";
		$data['laporan'] = $this->admin->report('inventory');
		$thn = $this->admin->getYearReport('inventory');
		$bln = $this->admin->getMonthReport('inventory');

		//buat array tahun berdasarkan data dari $thn
		$data['tahun'] = array(); // inisialisasi array kosong untuk menampung hasil query
		foreach ($thn as $row) {
			array_push($data['tahun'], $row['tahun']); // memasukkan tahun ke dalam array
		}

		$data['bulan'] = getBulan();

		$this->template->load('templates/dashboard', 'laporan/data', $data);
	}

	public function add()
	{
		$tahun = $this->input->post('tahun', true);
		$bulan = $this->input->post('bulan', true);
		$keterangan = $this->input->post('keterangan', true);

		//validasi
		$cek = $this->admin->get('report', ['bulan' => $bulan, 'tahun' => $tahun]);
		if ($cek) {
			set_pesan('laporan sudah ada!');
			redirect('laporaninventory');
		} else {
			//generate kode T-LB-YYMMX
			$kode = 'T-LB-' . $tahun . $bulan . 0;

			$data = [
				'id_report' => $kode,
				'year' => $tahun,
				'month' => $bulan,
				'additional_info' => $keterangan,
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
	}
}
