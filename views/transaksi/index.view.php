<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
</div>

<div class="card mb-4">
	<div class="card-header d-flex justify-content-between align-items-center py-3">
		<h5 class="m-0 font-weight-bold text-primary">Siswa</h5>
	</div>
	<div class="card-body">
		<form action="<?= route('transaksi') ?>" method="get">
			<div class="card py-1">
				<div class="card-body">
					<div class="form-group">
						<div class="row align-items-center">
							<div class="col-1">
								<label for="nis" class="m-0">Cari siswa</label>
							</div>
							<div class="col-2">
								<input id="text" max="5" name="nis" type="text"
									class="form-control bg-light border border-primary small" placeholder="NIS" value="<?= old('nis') ?>"
									required>
							</div>
							<div class="col">
								<button type="submit" class="btn btn-primary">Cari</submit>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<?php if (isset($siswa)): ?>
	<?php if (!$siswa->exists()): ?>
		<div class="alert alert-danger" role="alert">
			Siswa tidak ditemukan
		</div>
	<?php else: ?>
		<div class="card mb-4">
			<div class="card-header d-flex justify-content-between align-items-center py-3">
				<h5 class="m-0 font-weight-bold text-primary">Tentang Siswa</h5>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col">
						NIS
					</div>
					<div class="col-10">
						: <?= $siswa->nis ?>
					</div>
				</div>
				<div class="row mt-4">
					<div class="col">
						Nama
					</div>
					<div class="col-10">
						: <?= $siswa->nama ?>
					</div>
				</div>
				<div class="row mt-4">
					<div class="col">
						Tahun ajaran
					</div>
					<div class="col-10">
						: <?= $siswa->pembayaran->tahun_ajaran ?>
					</div>
				</div>
				<div class="row mt-4">
					<div class="col">
						Nominal
					</div>
					<div class="col-10">
						: <?="Rp " . number_format($siswa->pembayaran->nominal, 2, ',', '.') ?>
					</div>
				</div>
			</div>
		</div>

		<?php
		[$tahun1, $tahun2] = explode('/', $siswa->pembayaran->tahun_ajaran);
		?>

		<?php if (session()->hasFlash('transaksi-success')): ?>
			<div class="alert alert-success" role="alert">
				<?= session()->getFlash('transaksi-success') ?>
			</div>
		<?php endif ?>

		<?php if (session()->hasFlash('transaksi-failed')): ?>
			<div class="alert alert-danger" role="alert">
				<?= session()->getFlash('transaksi-failed') ?>
			</div>
		<?php endif ?>

		<div class="card mb-4">
			<div class="card-header d-flex justify-content-between align-items-center py-3">
				<h5 class="m-0 font-weight-bold text-primary">Transaksi</h5>
			</div>
			<div class="card-body">
				<div class="row">

					<?php for ($i = 7; $i <= 12; $i++): ?>
						<div class="col-2">
							<div class="card">
								<div class="card-body">
									<div class="d-flex flex-column align-items-center">
										<div class="d-flex flex-column align-items-center mb-2">
											<div class="text-primary font-weight-bold h4">
												<?= match ($i) {
													7 => 'Juli',
													8 => 'Agustus',
													9 => 'September',
													10 => 'Oktober',
													11 => 'November',
													12 => 'Desember',
												} ?>
											</div>
											<div class=" h6"><?= $tahun1 ?></div>
										</div>

										<?php if (in_array($i, $paidOffMonths)): ?>
											<button class="btn btn-primary" type="submit" disabled>Lunas</button>
										<?php else: ?>
											<form action="<?= route('transaksi.pay', ['id' => $siswa->id]) ?>" method="post">
												<input type="hidden" name="month" value="<?= $i ?>">
												<input type="hidden" name="year" value="<?= $tahun1 ?>">
												<button class="btn btn-primary" type="submit">Bayar</button>
											</form>
										<?php endif ?>

									</div>
								</div>
							</div>
						</div>
					<?php endfor; ?>

				</div>

				<div class="row mt-4">

					<?php for ($i = 1; $i <= 6; $i++): ?>
						<div class="col-2">
							<div class="card">
								<div class="card-body">
									<div class="d-flex flex-column align-items-center">
										<div class="d-flex flex-column align-items-center mb-2">
											<div class="text-primary font-weight-bold h4">
												<?= match ($i) {
													1 => 'Januari',
													2 => 'Februari',
													3 => 'Maret',
													4 => 'April',
													5 => 'Mei',
													6 => 'Juni',
												} ?>
											</div>
											<div class=" h6"><?= $tahun2 ?></div>
										</div>

										<?php if (in_array($i, $paidOffMonths)): ?>
											<button class="btn btn-primary" type="submit" disabled>Lunas</button>
										<?php else: ?>
											<form action="<?= route('transaksi.pay', ['id' => $siswa->id]) ?>" method="post">
												<input type="hidden" name="month" value="<?= $i ?>">
												<input type="hidden" name="year" value="<?= $tahun2 ?>">
												<button class="btn btn-primary" type="submit">Bayar</button>
											</form>
										<?php endif ?>

									</div>
								</div>
							</div>
						</div>
					<?php endfor; ?>

				</div>

			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>