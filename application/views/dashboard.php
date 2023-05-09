<hr><div class="card-header bg-white">
<h5 class="text-black op-7 mb-2"><img src="assets/img/2.png" width="37px"> Hello, <b class="text-info"><?= userdata('nama'); ?></b></h5>
        <h4 class="h5 align-middle m-0 font-weight-bold text-danger">
            <marquee>Welcome To Housekeeping Inventory Application Information System</marquee>
        </h4>
    </div>

<br>
<div class="row">

		<div class="col-xl-4 col-6 mb-4">
			<div class="card border-left-info shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="row no-gutters align-items-center">
								<div class="col mr-2">
									<div class="text-xs font-weight-bold text-info text-uppercase mb-1"><a href="barang" style="text-decoration:none;color:#0FBDF1">Total Stock</a></div>
									<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stok; ?></div>
								</div>
								<div class="col-auto">
									<div class="progress progress-sm mr-2">
										<div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-auto">
							<i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-6 mb-4">
			<div class="card border-left-warning shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-success text-uppercase mb-1"><a href="barangmasuk" style="text-decoration:none; color:#FFA600  " >Jumlah Barang Masuk</a></div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $barang_masuk; ?></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-download fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-6 mb-4">
			<div class="card border-left-danger h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-success text-uppercase mb-1"><a href="barangkeluar" style="text-decoration:none; color:#FF0000 " >Jumlah Barang Keluar</a></div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $barang_keluar; ?></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-upload fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-4 col-6 mb-4">
			<div class="card border-left-primary h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><a href="barang" style="text-decoration:none;color:#2A6AFF" >Total Item Data</a></div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $barang; ?></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-bars fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-6 mb-4">
			<div class="card border-left-success shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-success text-uppercase mb-1"><a href="supplier" style="text-decoration:none; color:#49FF00 " >Data Supplier</a></div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $supplier; ?></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-users fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-6 mb-4">
		<div class="card border-left-secondary h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-warning text-uppercase mb-1"><a href="user" style="text-decoration:none; color:#AC6767  " >Total Users</a></div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $user; ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-user-plus fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
		<!-- Area Chart -->
		<div class="col-xl-8 col-lg-7">
			<div class="card shadow mb-4">
				<!-- Card Header - Dropdown -->
				<div class="card-header bg-primary py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-white">Total Transaksi Barang Perbulan pada Tahun <?= date('Y'); ?></h6>
				</div>
				<!-- Card Body -->
				<div class="card-body">
					<div class="chart-area">
						<div class="chartjs-size-monitor">
							<div class="chartjs-size-monitor-expand">
								<div class=""></div>
							</div>
							<div class="chartjs-size-monitor-shrink">
								<div class=""></div>
							</div>
						</div>
						<canvas id="myAreaChart" width="669" height="320" class="chartjs-render-monitor" style="display: block; width: 669px; height: 320px;"></canvas>
					</div>

				</div>
			</div>
		</div>

		<!-- Pie Chart -->
		<div class="col-xl-4 col-lg-5">
			<div class="card shadow mb-4">
				<!-- Card Header - Dropdown -->
				<div class="card-header bg-primary py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-white">Transaksi Barang</h6>
				</div>
				<!-- Card Body -->
				<div class="card-body">
					<div class="chart-pie pt-4 pb-2">
						<div class="chartjs-size-monitor">
							<div class="chartjs-size-monitor-expand">
								<div class=""></div>
							</div>
							<div class="chartjs-size-monitor-shrink">
								<div class=""></div>
							</div>
						</div>
						<canvas id="myPieChart" width="302" height="245" class="chartjs-render-monitor" style="display: block; width: 302px; height: 245px;"></canvas>
					</div>
					<div class="mt-4 text-center small">
						<span class="mr-2">
							<i class="fas fa-circle text-primary"></i> Barang Masuk
						</span>
						<span class="mr-2">
							<i class="fas fa-circle text-danger"></i> Barang Keluar
						</span>
						<span class="mr-2">
							<i class="fas fa-circle text-warning"></i> Barang Rusak
						</span>
						<span class="mr-2">
							<i class="fas fa-circle text-dark"></i> Barang Hilang
						</span>
					</div>
				</div>
			</div>
		</div>

		<!-- Top 5 Barang Masuk -->
		<div class="col-md-3">
			<div class="card shadow mb-4">
				<div class="card-header bg-success py-3">
					<h6 class="m-0 font-weight-bold text-white text-center">5 Teratas Barang Masuk Bulan Ini</h6>
				</div>
				<div class="table-responsive">
					<table class="table mb-0 table-sm table-striped text-center">
						<thead>
						<tr>
							<th>Barang</th>
							<th>Total</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($ranking['barang_masuk_top'] as $tbm) : ?>
							<tr>
								<td><?= $tbm['nama_barang']; ?></td>
								<td><span class="badge badge-success"><?= $tbm['total_masuk']; ?></span></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<!-- Bottom 5 Barang Masuk -->
		<div class="col-md-3">
			<div class="card shadow mb-4">
				<div class="card-header bg-warning py-3">
					<h6 class="m-0 font-weight-bold text-white text-center">5 Terendah Barang Masuk Bulan Ini</h6>
				</div>
				<div class="table-responsive">
					<table class="table mb-0 table-sm table-striped text-center">
						<thead>
						<tr>
							<th>Barang</th>
							<th>Total</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($ranking['barang_masuk_bottom'] as $tbm) : ?>
							<tr>
								<td><?= $tbm['nama_barang']; ?></td>
								<td><span class="badge badge-warning"><?= $tbm['total_masuk']; ?></span></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			</div>

		<!-- Top 5 Barang Rusak -->
		<div class="col-md-6">
			<div class="card shadow mb-4">
				<div class="card-header bg-danger py-3">
					<h6 class="m-0 font-weight-bold text-white text-center">5 Teratas Barang Rusak Bulan Ini</h6>
				</div>
				<div class="table-responsive">
					<table class="table mb-0 table-sm table-striped text-center">
						<thead>
						<tr>
							<th>Barang</th>
							<th>Total</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($ranking['barang_rusak_top'] as $tbm) : ?>
							<tr>
								<td><?= $tbm['nama_barang']; ?></td>
								<td><span class="badge badge-danger"><?= $tbm['total_rusak']; ?></span></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<!-- Top 5 Barang Keluar -->
		<div class="col-md-3">
			<div class="card shadow mb-4">
				<div class="card-header bg-success py-3">
					<h6 class="m-0 font-weight-bold text-white text-center">5 Teratas Barang Keluar Bulan Ini</h6>
				</div>
				<div class="table-responsive">
					<table class="table mb-0 table-sm table-striped text-center">
						<thead>
						<tr>
							<th>Barang</th>
							<th>Total</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($ranking['barang_keluar_top'] as $tbm) : ?>
							<tr>
								<td><?= $tbm['nama_barang']; ?></td>
								<td><span class="badge badge-success"><?= $tbm['total_keluar']; ?></span></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<!-- Bottom 5 Barang Keluar -->
		<div class="col-md-3">
			<div class="card shadow mb-4">
				<div class="card-header bg-warning py-3">
					<h6 class="m-0 font-weight-bold text-white text-center">5 Terendah Barang Keluar Bulan Ini</h6>
				</div>
				<div class="table-responsive">
					<table class="table mb-0 table-sm table-striped text-center">
						<thead>
						<tr>
							<th>Barang</th>
							<th>Total</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($ranking['barang_keluar_bottom'] as $tbm) : ?>
							<tr>
								<td><?= $tbm['nama_barang']; ?></td>
								<td><span class="badge badge-warning"><?= $tbm['total_keluar']; ?></span></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<!-- Top 5 Barang Hilang -->
		<div class="col-md-6">
			<div class="card shadow mb-4">
				<div class="card-header bg-dark py-3">
					<h6 class="m-0 font-weight-bold text-white text-center">5 Teratas Barang Hilang Bulan Ini</h6>
				</div>
				<div class="table-responsive">
					<table class="table mb-0 table-sm table-striped text-center">
						<thead>
						<tr>
							<th>Barang</th>
							<th>Total</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($ranking['barang_hilang_top'] as $tbm) : ?>
							<tr>
								<td><?= $tbm['nama_barang']; ?></td>
								<td><span class="badge badge-danger"><?= $tbm['total_hilang']; ?></span></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

    	<div class="col-md-6">
			<div class="card shadow mb-4">
				<div class="card-header bg-info py-3">
					<h6 class="m-0 font-weight-bold text-white text-center">5 Transaksi Terakhir Barang Masuk</h6>
				</div>
				<div class="table-responsive">
					<table class="table mb-0 table-sm table-striped text-center">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>Barang</th>
								<th>Jumlah</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($transaksi['barang_masuk'] as $tbm) : ?>
								<tr>
									<td><strong><?= $tbm['tanggal_masuk']; ?></strong></td>
									<td><?= $tbm['nama_barang']; ?></td>
									<td><span class="badge badge-success"><?= $tbm['jumlah_masuk']; ?></span></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card shadow mb-4">
				<div class="card-header bg-danger py-3">
					<h6 class="m-0 font-weight-bold text-white text-center">5 Transaksi Terakhir Barang Keluar</h6>
				</div>
				<div class="table-responsive">
					<table class="table mb-0 table-sm table-striped text-center">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>Barang</th>
								<th>Jumlah</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($transaksi['barang_keluar'] as $tbk) : ?>
								<tr>
									<td><strong><?= $tbk['tanggal_keluar']; ?></strong></td>
									<td><?= $tbk['nama_barang']; ?></td>
									<td><span class="badge badge-danger"><?= $tbk['jumlah_keluar']; ?></span></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
</div>
