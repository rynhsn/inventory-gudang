<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		cek_login();

		$this->load->model('Admin_model', 'admin');
		$this->load->model('Report_model', 'report');
		$this->load->library('form_validation');
	}

	public function print()
	{
		$this->form_validation->set_rules('transaksi', 'Transaksi', 'required|in_list[barang_masuk,barang_keluar]');
		$this->form_validation->set_rules('tanggal', 'Periode Tanggal', 'required');

		if ($this->form_validation->run() == false) {
			$data['title'] = "Transaction Report";
			$this->template->load('templates/dashboard', 'laporan/form', $data);
		} else {
			$input = $this->input->post(null, true);
			$table = $input['transaksi'];
			$tanggal = $input['tanggal'];
			$pecah = explode(' - ', $tanggal);
			$mulai = date('Y-m-d', strtotime($pecah[0]));
			$akhir = date('Y-m-d', strtotime(end($pecah)));

			$query = '';
			if ($table == 'barang_masuk') {
				$query = $this->admin->getBarangMasuk(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
			} else {
				$query = $this->admin->getBarangKeluar(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
			}

			$this->_cetak($query, $table, $tanggal);
		}
	}

	private function _cetak($data, $table_, $tanggal)
	{
		$this->load->library('CustomPDF');
		$table = $table_ == 'barang_masuk' ? 'Barang Masuk' : 'Barang Keluar';

		$pdf = new FPDF();
		$pdf->AddPage('L', 'Letter');
		$pdf->SetFont('Times', 'B', 16);
		$pdf->Image('./assets/img/logo1.png', 10, 8, 17, 15);
		$pdf->Image('./assets/img/2.png', 255, 8, 15, 14);
		$pdf->Cell(260, 7, 'Laporan ' . $table, 0, 1, 'C');
		$pdf->SetFont('Times', '', 10);
		$pdf->Cell(260, 4, 'Tanggal : ' . $tanggal, 0, 1, 'C');
		$pdf->Line(10, 25, 270, 25);
		$pdf->Ln(10);

		$pdf->SetFont('Arial', 'B', 10);

		if ($table_ == 'barang_masuk') :
			$pdf->Cell(10, 7, 'No.', 1, 0, 'C');
			$pdf->Cell(35, 7, 'Tgl Masuk', 1, 0, 'C');
			$pdf->Cell(40, 7, 'ID Transaksi', 1, 0, 'C');
			$pdf->Cell(55, 7, 'Nama Barang', 1, 0, 'C');
			$pdf->Cell(47, 7, 'Supplier', 1, 0, 'C');
			$pdf->Cell(30, 7, 'Jumlah Masuk', 1, 0, 'C');
			$pdf->Cell(42, 7, 'Penanggung Jawab', 1, 0, 'C');
			$pdf->Ln();

			$no = 1;
			foreach ($data as $d) {
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
				$pdf->Cell(35, 7, $d['tanggal_masuk'], 1, 0, 'C');
				$pdf->Cell(40, 7, $d['id_barang_masuk'], 1, 0, 'C');
				$pdf->Cell(55, 7, $d['nama_barang'], 1, 0, 'L');
				$pdf->Cell(47, 7, $d['nama_supplier'], 1, 0, 'L');
				$pdf->Cell(30, 7, $d['jumlah_masuk'] . ' ' . $d['nama_satuan'], 1, 0, 'C');
				$pdf->Cell(42, 7, $d['nama'], 1, 0, 'C');
				$pdf->Ln();
			}
			$pdf->Ln(60);
			$pdf->Cell(75);
			$pdf->Cell(270, 7, 'Bandung, ' . date('d-m-y'), 0, 1, 'C');
			$pdf->Cell(75);
			$pdf->Cell(270, 7, 'Kepala Gudang,', 0, 1, 'C');
			$pdf->Ln(20);
			$pdf->Cell(75);
			$pdf->SetFont('Times', 'B', 15);
			$pdf->Cell(270, 7, 'KaSetya, S.Tr, M.Kom', 0, 1, 'C');
			$pdf->SetFont('Times', '', 12);
			$pdf->Cell(75);
			$pdf->Cell(270, 7, 'NIP. 19601113 198603 1 003,', 0, 1, 'C');
		else :
			$pdf->Cell(10, 7, 'No.', 1, 0, 'C');
			$pdf->Cell(30, 7, 'Tanggal Keluar', 1, 0, 'C');
			$pdf->Cell(40, 7, 'ID Transaksi', 1, 0, 'C');
			$pdf->Cell(50, 7, 'Nama Barang', 1, 0, 'C');
			$pdf->Cell(35, 7, 'Jumlah Keluar', 1, 0, 'C');
			$pdf->Cell(48, 7, 'Lokasi', 1, 0, 'C');
			$pdf->Cell(47, 7, 'Penanggung Jawab', 1, 0, 'C');
			$pdf->Ln();

			$no = 1;
			foreach ($data as $d) {
				$pdf->SetFont('Arial', '', 10);
				$pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
				$pdf->Cell(30, 7, $d['tanggal_keluar'], 1, 0, 'C');
				$pdf->Cell(40, 7, $d['id_barang_keluar'], 1, 0, 'C');
				$pdf->Cell(50, 7, $d['nama_barang'], 1, 0, 'L');
				$pdf->Cell(35, 7, $d['jumlah_keluar'] . ' ' . $d['nama_satuan'], 1, 0, 'C');
				$pdf->Cell(48, 7, $d['lokasi'], 1, 0, 'C');
				$pdf->Cell(47, 7, $d['nama'], 1, 0, 'C');
				$pdf->Ln();
			}
			$pdf->Ln(60);
			$pdf->Cell(75);
			$pdf->Cell(270, 7, 'Bandung, ' . date('d-m-y'), 0, 1, 'C');
			$pdf->Cell(75);
			$pdf->Cell(270, 7, 'Kepala Gudang,', 0, 1, 'C');
			$pdf->Ln(20);
			$pdf->Cell(75);
			$pdf->SetFont('Times', 'B', 15);
			$pdf->Cell(270, 7, 'KaSetya, S.Tr, M.Kom', 0, 1, 'C');
			$pdf->SetFont('Times', '', 12);
			$pdf->Cell(75);
			$pdf->Cell(270, 7, 'NIP. 19601113 198603 1 003,', 0, 1, 'C');

		endif;
		ob_end_clean();
		$file_name = $table . ' ' . $tanggal;
		$pdf->Output('I', $file_name);
	}

	public function index()
	{
		$data['title'] = "Laporan";
		$data['laporan'] = $this->report->report();

		$thn = $this->report->getYearReport();

		//buat array tahun berdasarkan data dari $thn
		$data['tahun'] = array(); // inisialisasi array kosong untuk menampung hasil query
		foreach ($thn as $row) {
			array_push($data['tahun'], $row['tahun']); // memasukkan tahun ke dalam array
		}

		$this->template->load('templates/dashboard', 'laporan/data', $data);
	}

	public function detail($id)
	{
		$data['title'] = "Detail Laporan";
		$data['laporan'] = $this->report->report($id);
		$data['barang'] = $this->admin->get('report_detail',null, ['id_report' => $id]);

		$this->template->load('templates/dashboard', 'laporan/detail', $data);
	}

	public function verify($id, $verify = null)
	{
		$verify = $verify == null ? 1 : 2;

		$data = [
			'is_verified' => $verify,
			'rejected_note' => $this->input->post('keterangan', true),
			'verified_at' => time(),
		];

		var_dump($data);
		$this->admin->update('report', 'id_report', $id, $data);

		set_pesan('Status berhasil diubah.');

		$redirect = $this->session->flashdata('redirect');
		if ($redirect == 'detail') redirect('laporan/detail/' . $id);
		redirect('laporan');
	}

	public function add()
	{
		$tahun = $this->input->post('tahun', true);
		$bulan = $this->input->post('bulan', true);
		$keterangan = $this->input->post('keterangan', true);

		//validasi
		$cek = $this->admin->get('report', ['month' => $bulan, 'year' => $tahun]);
		if ($cek) {
			set_pesan('laporan sudah ada!', false);
		} else {
			$kode = 'T-LB-' . $tahun . sprintf("%02d", $bulan);

			$data = [
				'id_report' => $kode,
				'year' => $tahun,
				'month' => $bulan,
				'additional_info' => $keterangan,
				'is_verified' => 0,
				'verified_at' => null,
				'created_by' => $this->session->userdata('login_session')['user'],
			];
			$this->admin->insert('report', $data);

			$report = $this->report->getReport($bulan, $tahun);
			$this->_insertDetail($report, $kode);

			set_pesan('laporan berhasil disimpan.');
		}
		redirect('laporan');
	}

	public function update($id)
	{
		$this->admin->delete('report_detail', 'id_report', $id);
		$report = $this->admin->get('report', ['id_report' => $id]);
		$data = $this->report->getReport($report['month'], $report['year']);
		$this->_insertDetail($data, $id);
		if ($report['is_verified'] == 2) {
			$data = [
				'is_verified' => 3,
			];
			$this->admin->update('report', 'id_report', $id, $data);
		}

		set_pesan('laporan berhasil diperbarui.');

		$redirect = $this->session->flashdata('redirect');
		if ($redirect == 'detail') redirect('laporan/detail/' . $id);
		redirect('laporan');
	}

	public function delete($id)
	{
		$this->admin->delete('report', 'id_report', $id);
		$this->admin->delete('report_detail', 'id_report', $id);
		set_pesan('laporan berhasil dihapus.');
		redirect('laporan');
	}

	public function cetak($id){
		$header = $this->admin->get('report', ['id_report' => $id]);
		$creator = $this->admin->get('user', ['id_user' => $header['created_by']])['nama'];
		$detail = $this->admin->get('report_detail', null, ['id_report' => $id]);

		$this->load->library('CustomPDF');

		$pdf = new FPDF();
		$pdf->AddPage('L', 'Letter');
		$pdf->SetFont('Times', 'B', 16);
		$pdf->Image('./assets/img/logo1.png', 10, 8, 17, 15);
		$pdf->Image('./assets/img/2.png', 255, 8, 15, 14);
		$pdf->Cell(260, 7, 'Laporan Barang', 0, 1, 'C');
		$pdf->SetFont('Times', '', 10);
		$pdf->Cell(260, 4, 'Periode : ' . getBulan($header['month']) . ' ' . $header['year'], 0, 1, 'C');
		$pdf->Line(10, 25, 270, 25);
		$pdf->Ln(10);

		$pdf->SetFont('Arial', 'B', 10);

		$pdf->Cell(10, 7, 'No.', 1, 0, 'C');
		$pdf->Cell(35, 7, 'Kode Barang', 1, 0, 'C');
		$pdf->Cell(40, 7, 'Nama Barang', 1, 0, 'C');
		$pdf->Cell(27, 7, 'Stok Masuk', 1, 0, 'C');
		$pdf->Cell(27, 7, 'Stok Keluar', 1, 0, 'C');
		$pdf->Cell(27, 7, 'Stok Rusak', 1, 0, 'C');
		$pdf->Cell(27, 7, 'Stok Hilang', 1, 0, 'C');
		$pdf->Cell(27, 7, 'Stok Akhir', 1, 0, 'C');
		$pdf->Cell(40, 7, 'Penanggung Jawab', 1, 0, 'C');
		$pdf->Ln();

		$no = 1;
		foreach ($detail as $d) {
			$pdf->SetFont('Arial', '', 10);
			$pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
			$pdf->Cell(35, 7, $d['id_barang'], 1, 0, 'C');
			$pdf->Cell(40, 7, $d['nama_barang'], 1, 0, 'C');
			$pdf->Cell(27, 7, $d['stok_masuk'], 1, 0, 'C');
			$pdf->Cell(27, 7, $d['stok_keluar'], 1, 0, 'C');
			$pdf->Cell(27, 7, $d['stok_rusak'], 1, 0, 'C');
			$pdf->Cell(27, 7, $d['stok_hilang'], 1, 0, 'C');
			$pdf->Cell(27, 7, $d['stok_akhir'], 1, 0, 'C');
			$pdf->Cell(40, 7, $creator, 1, 0, 'C');
			$pdf->Ln();
		}
		$pdf->Ln(60);
		$pdf->Cell(75);
		$pdf->Cell(270, 7, 'Serang, ' . date('d-m-y'), 0, 1, 'C');
		$pdf->Cell(75);
		$pdf->Cell(270, 7, 'Executive Housekeeper,', 0, 1, 'C');
		$pdf->Ln(20);
		$pdf->Cell(75);
		$pdf->SetFont('Times', 'B', 15);
		$pdf->Cell(270, 7, 'KaSetya, S.Tr, M.Kom', 0, 1, 'C');
		$pdf->SetFont('Times', '', 12);
		$pdf->Cell(75);
		$pdf->Cell(270, 7, 'NIP. 19601113 198603 1 003,', 0, 1, 'C');

		ob_end_clean();
		$file_name = 'Laporan Barang Periode ' . getBulan($header['month']) . ' ' . $header['year'];
		$pdf->Output('I', $file_name);
	}

	private function _insertDetail($data, $kode)
	{
		foreach ($data as $r) {
			$data = [
				'id_report' => $kode,
				'id_barang' => $r['id_barang'],
				'nama_barang' => $r['nama_barang'],
				'stok_masuk' => $r['stok_masuk'],
				'stok_keluar' => $r['stok_keluar'],
				'stok_rusak' => $r['stok_rusak'],
				'stok_hilang' => $r['stok_hilang'],
				'stok_akhir' => $r['stok_akhir'],
			];
			$this->admin->insert('report_detail', $data);
		}
	}
}
