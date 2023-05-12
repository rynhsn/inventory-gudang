<?php error_reporting(0);
$this->session->set_flashdata('redirect', 'detail');
?>
<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
	<div class="card-header bg-white py-3">
		<div class="row">
			<div class="col">
				<h4 class="h5 align-middle m-0 font-weight-bold text-primary">
					<?= $title; ?>
				</h4>
			</div>
			<div class="col-auto">

				<?php if ($this->session->userdata('login_session')['role'] == 'ehk'): ?>
					<a href="<?= base_url('laporan/verify/') . $laporan['id_report'] ?>"
					   class="btn btn-success btn-circle btn-sm <?= $laporan['is_verified'] == 1 ? 'disabled' : '' ?>"
					   title="setujui">
						<i class="fa fa-check"></i>
					</a>

					<button type="button"
							class="btn btn-danger btn-circle btn-sm mr-3"
							data-toggle="modal"
							data-target="#rejectModal" <?= $laporan['is_verified'] > 0 && $laporan['is_verified'] < 3 ? 'disabled' : '' ?>>
						<i class="fa fa-times"></i>
					</button>
				<?php endif; ?>
				<a href="<?= base_url('laporan/cetak/' . $laporan['id_report']) ?>"
				   class="btn btn-primary btn-circle btn-sm <?= $laporan['is_verified'] == 1 ? '' : 'disabled' ?>"
				   title="cetak">
					<i class="fa fa-print"></i>
				</a>

				<?php if ($this->session->userdata('login_session')['role'] == 'spv'): ?>
					<a onclick="return confirm('Laporan akan diperbarui, yakin?')"
					   href="<?= base_url('laporan/update/') . $laporan['id_report'] ?>"
					   class="btn btn-success btn-circle btn-sm ml-3 <?= $laporan['is_verified'] == 1 || $laporan['is_verified'] == 3 ? 'disabled' : '' ?>"
					   title="perbarui">
						<i class="fas fa-sync-alt"></i>
					</a>

					<a onclick="return confirm('Yakin ingin hapus?')"
					   href="<?= base_url('laporan/delete/') . $laporan['id_report'] ?>"
					   class="btn btn-danger btn-circle btn-sm  <?= $laporan['is_verified'] > 0 ? 'disabled' : '' ?>"
					   title="hapus">
						<i class="fa fa-trash"></i>
					</a>
				<?php endif; ?>
				<a href="<?= base_url('laporan'); ?>" class="btn btn-sm btn-primary btn-icon-split ml-5">
					<span class="icon">
                        <i class="fa fa-arrow-left"></i>
                    </span>
					<span class="text">
                        Kembali
                    </span>
				</a>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-4">
				<div class="row form-group">
					<label class="col-md-4 text-md-right" for="id_report">Kode Laporan</label>
					<div class="col-md">
						<input value="<?= $laporan['id_report']; ?>" type="text" readonly="readonly"
							   class="form-control bg-transparent">
					</div>
				</div>
				<div class="row form-group">
					<label class="col-md-4 text-md-right" for="periode">Periode</label>
					<div class="col-md">
						<input value="<?= getbulan($laporan['month']) . ' ' . $laporan['year']; ?>" type="text"
							   readonly="readonly" class="form-control bg-transparent">
					</div>
				</div>
				<div class="row form-group">
					<label class="col-md-4 text-md-right" for="keterangan">Keterangan</label>
					<div class="col-md">
						<textarea readonly="readonly" class="form-control bg-transparent"
								  rows="6"><?= $laporan['additional_info']; ?>
						</textarea>
					</div>
				</div>
			</div>
			<div class="col-4">
				<div class="row form-group">
					<label class="col-md-4 text-md-right" for="created_by">Dibuat Oleh</label>
					<div class="col-md">
						<input value="<?= $laporan['nama']; ?>" type="text" readonly="readonly"
							   class="form-control bg-transparent">
					</div>
				</div>
				<div class="row form-group">
					<label class="col-md-4 text-md-right" for="created_at">Dibuat Pada</label>
					<div class="col-md">
						<input value="<?= date('d M y', $laporan['created_at']); ?>" type="text" readonly="readonly"
							   class="form-control bg-transparent">
					</div>
				</div>
				<div class="row form-group">
					<label class="col-md-4 text-md-right" for="id_report">Status</label>
					<div class="col-md-3">
						<span
							class="badge <?= getStatus($laporan['is_verified'])[1]; ?>"><?= getStatus($laporan['is_verified'])[0]; ?></span>
					</div>
					<?php if ($laporan['is_verified'] == 1) : ?>
						<div class="col-md-5">
							<input value="<?= date('d M y', $laporan['verified_at']); ?>" type="text"
								   readonly="readonly"
								   class="form-control bg-transparent">
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="col-4">
				<div class="row form-group">
					<label class="col-md-4 text-md-right" for="keterangan">Catatan Ditolak</label>
					<div class="col-md">
						<textarea readonly="readonly" class="form-control bg-transparent"
								  rows="6"><?= $laporan['rejected_note']; ?>
						</textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="table-responsive">
		<table class="table table-striped w-100 dt-responsive " id="dataTable">
			<thead>
			<tr>
				<th>No.</th>
				<th>Kode Barang</th>
				<th>Nama Barang</th>
				<th>Stok Masuk</th>
				<th>Stok Keluar</th>
				<th>Stok Rusak</th>
				<th>Stok Hilang</th>
				<th>Stok Akhir</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$no = 1;
			if ($barang) :
				foreach ($barang as $b) :
					?>
					<tr>
						<td><?= $no++; ?></td>
						<td><?= $b['id_barang']; ?></td>
						<td><?= $b['nama_barang']; ?></td>
						<td><?= $b['stok_masuk']; ?></td>
						<td><?= $b['stok_keluar']; ?></td>
						<td><?= $b['stok_rusak']; ?></td>
						<td><?= $b['stok_hilang']; ?></td>
						<td><?= $b['stok_akhir']; ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td colspan="7" class="text-center">
						Data Kosong
					</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<!--modal reject-->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog"
	 aria-labelledby="rejectModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content shadow-sm border-bottom-danger">
			<div class="modal-header bg-white py-3">
				<h5 class="modal-title h5 align-middle m-0 font-weight-bold text-danger" id="exampleModalLongTitle">
					Tambah Catatan Ditolak</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?= form_open(base_url('laporan/verify/' . $laporan['id_report'] . '/2')); ?>
				<div class="row form-group">
					<label class="col-lg-3 text-lg-right" for="bulan">Keterangan</label>
					<div class="col-lg">
						<textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-lg-9 offset-lg-3">
						<button type="submit" class="btn btn-danger btn-icon-split">
                            <span class="icon">
                                <i class="fa fa-save"></i>
                            </span>
							<span class="text">
                                Tambahkan
                            </span>
						</button>
					</div>
				</div>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</div>
