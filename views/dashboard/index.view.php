<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<div class="row">
	<?php if ($pengguna->isAdmin()): ?>
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
								Total Transaksi (Hari Ini)
							</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalTransaksiToday ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
								Total Transaksi (Bulan Ini)
							</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalTransaksiThisMonth ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if ($pengguna->isSiswa()): ?>
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
								Status SPP Bulan Ini
							</div>
							<div class="mt-2">
								<span
									class="h5 mb-0 font-weight-bold text-white px-2 py-1 rounded <?= $sppStatus ? 'bg-success' : 'bg-danger' ?>"><?= $sppStatus ? 'Lunas' : 'Belum Lunas' ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>

<div class="my-5">
	<video class="rounded" width="50%" autoplay muted>
		<source src="<?= asset('video/dashboard.mp4') ?>" type="video/mp4">
		Your browser does not support the video tag.
	</video>
</div>