<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_model extends CI_Model
{

	public function laporan($table, $mulai, $akhir)
	{
		$tgl = $table == 'barang_masuk' ? 'tanggal_masuk' : 'tanggal_keluar';
		$this->db->where($tgl . ' >=', $mulai);
		$this->db->where($tgl . ' <=', $akhir);
		return $this->db->get($table)->result_array();
	}

	public function report($id=null)
	{
		$this->db->select('*');
		$this->db->join('user u', 'lb.created_by = u.id_user');
		if ($id != null) {
			$this->db->where('id_report', $id);
			return $this->db->get('report lb')->row_array();
		}
		$this->db->order_by('id_report', 'DESC');
		return $this->db->get('report lb')->result_array();
	}
	public function getYearReport()
	{
		$query = "SELECT tahun FROM (SELECT YEAR(tanggal_masuk) AS tahun FROM barang_masuk
           UNION SELECT YEAR(tanggal_keluar) AS tahun FROM barang_keluar 
           UNION SELECT YEAR(tanggal_rusak) AS tahun FROM barang_rusak
           UNION SELECT YEAR(tanggal_hilang) AS tahun FROM barang_hilang) AS years";
		return $this->db->query($query)->result_array();
	}
	public function getMonthReport()
	{
		$query = "SELECT bulan FROM 
          (SELECT MONTH(tanggal_masuk) AS bulan FROM barang_masuk
           UNION 
           SELECT MONTH(tanggal_keluar) AS bulan FROM barang_keluar
           UNION
           SELECT MONTH(tanggal_rusak) AS bulan FROM barang_rusak
           UNION 
           SELECT MONTH(tanggal_hilang) AS bulan FROM barang_hilang) AS bulan_table";
		return $this->db->query($query)->result_array();
	}
	public function getReport($bulan, $tahun)
	{
		$query = "SELECT b.id_barang, b.nama_barang, b.stok AS stok_akhir,
			SUM(IFNULL(bm.jumlah_masuk, 0)) AS stok_masuk,
			SUM(IFNULL(bk.jumlah_keluar, 0)) AS stok_keluar,
			SUM(IFNULL(br.jumlah_rusak, 0)) AS stok_rusak,
			SUM(IFNULL(bh.jumlah_hilang, 0)) AS stok_hilang
			FROM barang b
			LEFT JOIN (
						SELECT barang_id, SUM(jumlah_masuk) AS jumlah_masuk
				FROM barang_masuk
				WHERE MONTH(tanggal_masuk) = $bulan AND YEAR(tanggal_masuk) = $tahun
				GROUP BY barang_id
			) AS bm ON b.id_barang = bm.barang_id
			LEFT JOIN (
						SELECT barang_id, SUM(jumlah_keluar) AS jumlah_keluar
				FROM barang_keluar
				WHERE MONTH(tanggal_keluar) = $bulan AND YEAR(tanggal_keluar) = $tahun
				GROUP BY barang_id
			) AS bk ON b.id_barang = bk.barang_id
			LEFT JOIN (
						SELECT barang_id, SUM(jumlah_rusak) AS jumlah_rusak
				FROM barang_rusak
				WHERE MONTH(tanggal_rusak) = $bulan AND YEAR(tanggal_rusak) = $tahun
				GROUP BY barang_id
			) AS br ON b.id_barang = br.barang_id
			LEFT JOIN (
						SELECT barang_id, SUM(jumlah_hilang) AS jumlah_hilang
				FROM barang_hilang
				WHERE MONTH(tanggal_hilang) = $bulan AND YEAR(tanggal_hilang) = $tahun
				GROUP BY barang_id
			) AS bh ON b.id_barang = bh.barang_id
			GROUP BY b.id_barang";
		return $this->db->query($query)->result_array();
	}
}
