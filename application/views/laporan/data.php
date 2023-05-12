<?php error_reporting(0);
//	var_dump($this->session->userdata('login_session')['role']);die;
	$this->session->set_flashdata('redirect', 'laporan');
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

				<?php if($this->session->userdata('login_session')['role'] == 'spv'):?>
				<button type="button" class="btn btn-sm btn-primary btn-icon-split" data-toggle="modal"
						data-target="#addModal">
					<span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
					<span class="text">
                        Buat Laporan
                    </span>
				</button>
				<?php endif;?>
			</div>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-striped w-100 dt-responsive " id="dataTable">
			<thead>
			<tr>
				<th>No.</th>
				<th>Kode Laporan</th>
				<th>Periode</th>
				<th>Dibuat Oleh</th>
				<th>Tanggal Buat</th>
				<th>Status</th>
				<?php if($this->session->userdata('login_session')['role'] == 'ehk'):?>
				<th>Verifikasi</th>
				<?php endif;?>
				<th>Lihat</th>

				<?php if($this->session->userdata('login_session')['role'] == 'spv'):?>
				<th>Aksi</th>
				<?php endif;?>
			</tr>
			</thead>
			<tbody>
			<?php
			$no = 1;
			if ($laporan) :
				foreach ($laporan as $l) :
					?>
					<tr>
						<td><?= $no++; ?></td>
						<td><?= $l['id_report']; ?></td>
						<td><?= getbulan($l['month']) . ' ' . $l['year']; ?></td>
						<td><?= $l['nama']; ?></td>
						<td><?= date('d/m/y', $l['created_at']); ?></td>
						<td><span
								class="badge <?= getStatus($l['is_verified'])[1]; ?>"><?= getStatus($l['is_verified'])[0]; ?></span>
						</td>

						<?php if($this->session->userdata('login_session')['role'] == 'ehk'):?>
						<td>
							<a href="<?= base_url('laporan/verify/') . $l['id_report'] ?>"
							   class="btn btn-success btn-circle btn-sm <?= $l['is_verified'] == 1 ? 'disabled' : '' ?>"
							   title="setujui">
								<i class="fa fa-check"></i>
							</a>
							<button type="button"
									class="btn btn-danger btn-circle btn-sm mr-3"
									data-toggle="modal"
									data-target="#rejectModal<?= $l['id_report']; ?>" <?= $l['is_verified'] > 0 && $l['is_verified'] < 3 ? 'disabled' : '' ?>>
								<i class="fa fa-times"></i>
							</button>
						</td>
						<?php endif;?>
						<td>
							<a href="<?= base_url('laporan/detail/') . $l['id_report'] ?>"
							   class="btn btn-info btn-circle btn-sm"
							   title="detail">
								<i class="fa fa-eye"></i>
							</a>
						</td>


						<?php if($this->session->userdata('login_session')['role'] == 'spv'):?>
						<td>
							<a onclick="return confirm('Laporan akan diperbarui, yakin?')"
							   href="<?= base_url('laporan/update/') . $l['id_report'] ?>"
							   class="btn btn-success btn-circle btn-sm  <?= $l['is_verified'] == 1 || $l['is_verified'] == 3 ? 'disabled' : '' ?>"
							   title="perbarui">
								<i class="fas fa-sync-alt"></i>
							</a>

							<a href="<?= base_url('laporan/cetak/' . $l['id_report']) ?>"
							   class="btn btn-primary btn-circle btn-sm <?= $l['is_verified'] == 1 ? '' : 'disabled' ?>"
							   title="cetak" target="_blank">
								<i class="fa fa-print"></i>
							</a>

							<a onclick="return confirm('Yakin ingin hapus?')"
							   href="<?= base_url('laporan/delete/') . $l['id_report'] ?>"
							   class="btn btn-danger btn-circle btn-sm  <?= $l['is_verified'] > 0 ? 'disabled' : '' ?>"
							   title="hapus">
								<i class="fa fa-trash"></i>
							</a>
						</td>
						<?php endif;?>
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


<!--modal add-->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content shadow-sm border-bottom-primary">
			<div class="modal-header bg-white py-3">
				<h5 class="modal-title h5 align-middle m-0 font-weight-bold text-primary" id="exampleModalLongTitle">
					Buat Laporan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?= form_open('laporan/add'); ?>
				<div class="row form-group">
					<label class="col-lg-3 text-lg-right" for="tahun">Tahun</label>
					<div class="col-lg">
						<select name="tahun" id="tahun" class="custom-select">
							<option value="" selected="" disabled="">Pilih Tahun</option>
							<?php foreach ($tahun as $t) : ?>
								<option value="<?= $t; ?>"><?= $t; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<div class="row form-group">
					<label class="col-lg-3 text-lg-right" for="bulan">Bulan</label>
					<div class="col-lg">
						<select name="bulan" id="bulan" class="custom-select">
							<option value="" selected="" disabled="">Pilih Bulan</option>
							<?php foreach (getBulan() as $b) : ?>
								<option value="<?= $b[0]; ?>"><?= $b[1]; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="row form-group">
					<label class="col-lg-3 text-lg-right" for="bulan">Keterangan</label>
					<div class="col-lg">
						<textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-lg-9 offset-lg-3">
						<button type="submit" class="btn btn-primary btn-icon-split">
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

<?php foreach ($laporan as $l) : ?>
	<!--modal reject-->
	<div class="modal fade" id="rejectModal<?= $l['id_report']; ?>" tabindex="-1" role="dialog"
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
					<?= form_open('laporan/verify/' . $l['id_report'] . '/2'); ?>
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
<?php endforeach; ?>
