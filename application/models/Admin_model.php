<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
	public function get($table, $data = null, $where = null)
	{
		if ($data != null) {
			return $this->db->get_where($table, $data)->row_array();
		} else {
			return $this->db->get_where($table, $where)->result_array();
		}
	}

	public function update($table, $pk, $id, $data)
	{
		$this->db->where($pk, $id);
		return $this->db->update($table, $data);
	}

	public function insert($table, $data, $batch = false)
	{
		return $batch ? $this->db->insert_batch($table, $data) : $this->db->insert($table, $data);
	}

	public function delete($table, $pk, $id)
	{
		return $this->db->delete($table, [$pk => $id]);
	}

	public function getUsers($id)
	{
		/**
		 * ID disini adalah untuk data yang tidak ingin ditampilkan.
		 * Maksud saya disini adalah
		 * tidak ingin menampilkan data user yang digunakan,
		 * pada managemen data user
		 */
		$this->db->where('id_user !=', $id);
		return $this->db->get('user')->result_array();
	}

	public function getBarang()
	{
		$this->db->join('jenis j', 'b.jenis_id = j.id_jenis');
		$this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
		$this->db->join('gudang g', 'b.gudang_id = g.id_gudang');
		$this->db->order_by('id_barang');
		return $this->db->get('barang b')->result_array();
	}

	public function getBarangMasuk($limit = null, $id_barang = null, $range = null)
	{
		$this->db->select('*');
		$this->db->join('user u', 'bm.user_id = u.id_user');
		$this->db->join('supplier sp', 'bm.supplier_id = sp.id_supplier');
		$this->db->join('barang b', 'bm.barang_id = b.id_barang');
		$this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
		if ($limit != null) {
			$this->db->limit($limit);
		}

		if ($id_barang != null) {
			$this->db->where('id_barang', $id_barang);
		}

		if ($range != null) {
			$this->db->where('tanggal_masuk' . ' >=', $range['mulai']);
			$this->db->where('tanggal_masuk' . ' <=', $range['akhir']);
		}

		$this->db->order_by('id_barang_masuk', 'DESC');
		return $this->db->get('barang_masuk bm')->result_array();
	}

	public function rankingBarangMasuk($limit, $position)
	{
		$this->db->select('b.id_barang, b.nama_barang, SUM(bm.jumlah_masuk) as total_masuk');
		$this->db->join('barang b', 'bm.barang_id = b.id_barang');
		$this->db->where('MONTH(tanggal_masuk)', date('m')); // Hanya ambil data pada periode bulan sekarang
		$this->db->group_by('b.id_barang');
		if ($position == 'top') {
			$this->db->order_by('total_masuk', 'DESC');
		} else if ($position == 'bottom') {
			$this->db->order_by('total_masuk', 'ASC');
		}
		$this->db->limit($limit);
		return $this->db->get('barang_masuk bm')->result_array();
	}

	public function rankingBarang($jenis, $limit, $position)
	{
		$this->db->select('b.id_barang, b.nama_barang, SUM(bj.jumlah_' . $jenis . ') as total_' . $jenis);
		$this->db->join('barang b', 'bj.barang_id = b.id_barang');
		$this->db->where('MONTH(tanggal_' . $jenis . ')', date('m')); // hanya ambil data pada periode bulan sekarang
		$this->db->group_by('b.id_barang');
		if ($position == 'top') {
			$this->db->order_by('total_' . $jenis, 'DESC');
		} else if ($position == 'bottom') {
			$this->db->order_by('total_' . $jenis, 'ASC');
		}
		$this->db->limit($limit);
		return $this->db->get('barang_' . $jenis . ' bj')->result_array();
	}


	public function getBarangKeluar($limit = null, $id_barang = null, $range = null)
	{
		$this->db->select('*');
		$this->db->join('user u', 'bk.user_id = u.id_user');
		$this->db->join('barang b', 'bk.barang_id = b.id_barang');
		$this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
		if ($limit != null) {
			$this->db->limit($limit);
		}
		if ($id_barang != null) {
			$this->db->where('id_barang', $id_barang);
		}
		if ($range != null) {
			$this->db->where('tanggal_keluar' . ' >=', $range['mulai']);
			$this->db->where('tanggal_keluar' . ' <=', $range['akhir']);
		}
		$this->db->order_by('id_barang_keluar', 'DESC');
		return $this->db->get('barang_keluar bk')->result_array();
	}

	public function getBarangRusak($limit = null, $id_barang = null, $range = null)
	{
		$this->db->select('*');
		$this->db->join('user u', 'br.user_id = u.id_user');
		$this->db->join('barang b', 'br.barang_id = b.id_barang');
		$this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
		if ($limit != null) {
			$this->db->limit($limit);
		}
		if ($id_barang != null) {
			$this->db->where('id_barang', $id_barang);
		}
		if ($range != null) {
			$this->db->where('tanggal_rusak' . ' >=', $range['mulai']);
			$this->db->where('tanggal_rusak' . ' <=', $range['akhir']);
		}
		$this->db->order_by('id_barang_rusak', 'DESC');
		return $this->db->get('barang_rusak br')->result_array();
	}

	public function getBarangHilang($limit = null, $id_barang = null, $range = null)
	{
		$this->db->select('*');
		$this->db->join('user u', 'bh.user_id = u.id_user');
		$this->db->join('barang b', 'bh.barang_id = b.id_barang');
		$this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
		if ($limit != null) {
			$this->db->limit($limit);
		}
		if ($id_barang != null) {
			$this->db->where('id_barang', $id_barang);
		}
		if ($range != null) {
			$this->db->where('tanggal_hilang' . ' >=', $range['mulai']);
			$this->db->where('tanggal_hilang' . ' <=', $range['akhir']);
		}
		$this->db->order_by('id_barang_hilang', 'DESC');
		return $this->db->get('barang_hilang bh')->result_array();
	}

	public function getMax($table, $field, $kode = null)
	{
		$this->db->select_max($field);
		if ($kode != null) {
			$this->db->like($field, $kode, 'after');
		}
		return $this->db->get($table)->row_array()[$field];
	}

	public function count($table)
	{
		return $this->db->count_all($table);
	}

	public function sum($table, $field)
	{
		$this->db->select_sum($field);
		return $this->db->get($table)->row_array()[$field];
	}

	public function min($table, $field, $min)
	{
		$field = $field . ' <=';
		$this->db->where($field, $min);
		return $this->db->get($table)->result_array();
	}

	public function chartBarangMasuk($bulan)
	{
		$like = 'T-BM-' . date('y') . $bulan;
		$this->db->like('id_barang_masuk', $like, 'after');
		return count($this->db->get('barang_masuk')->result_array());
	}

	public function chartBarangKeluar($bulan)
	{
		$like = 'T-BK-' . date('y') . $bulan;
		$this->db->like('id_barang_keluar', $like, 'after');
		return count($this->db->get('barang_keluar')->result_array());
	}

	public function chartBarangRusak($bulan)
	{
		$like = 'T-BR-' . date('y') . $bulan;
		$this->db->like('id_barang_rusak', $like, 'after');
		return count($this->db->get('barang_rusak')->result_array());
	}

	public function chartBarangHilang($bulan)
	{
		$like = 'T-BH-' . date('y') . $bulan;
		$this->db->like('id_barang_hilang', $like, 'after');
		return count($this->db->get('barang_hilang')->result_array());
	}

	public function cekStok($id)
	{
		$this->db->join('satuan s', 'b.satuan_id=s.id_satuan');
		return $this->db->get_where('barang b', ['id_barang' => $id])->row_array();
	}
}
