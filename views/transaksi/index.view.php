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
						NISN
					</div>
					<div class="col-10">
						: <?= $siswa->nisn ?>
					</div>
				</div>
				<div class="row mt-4">
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
						Alamat
					</div>
					<div class="col-10">
						: <?= $siswa->alamat ?>
					</div>
				</div>
				<div class="row mt-4">
					<div class="col">
						Nomor telepon
					</div>
					<div class="col-10">
						: <?= $siswa->telepon ?>
					</div>
				</div>
			</div>
		</div>

		<?php
		[$tahun1, $tahun2] = explode('/', $siswa->pembayaran->tahun_ajaran);
		?>

		<div class="card mb-4">
			<div class="card-header d-flex justify-content-between align-items-center py-3">
				<h5 class="m-0 font-weight-bold text-primary">Transaksi</h5>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-2">
						<div class="card">
							<div class="card-body">
								<form action="<?= route('transaksi.pay', ['id' => $siswa->id]) ?>" method="post">
									<input type="hidden" name="month" value="7">
									<input type="hidden" name="year" value="<?= $tahun1 ?>">
									<div class="d-flex flex-column align-items-center">
										<div class="d-flex flex-column align-items-center mb-2">
											<div class="text-primary font-weight-bold h4">Juli</div>
											<div class=" h6"><?= $tahun1 ?></div>
										</div>
										<button class="btn btn-primary" type="submit">Bayar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-2">
						<div class="card">
							<div class="card-body">
								<form action="<?= route('transaksi.pay', ['id' => $siswa->id]) ?>" method="post">
									<input type="hidden" name="month" value="8">
									<input type="hidden" name="year" value="<?= $tahun1 ?>">
									<div class="d-flex flex-column align-items-center">
										<div class="d-flex flex-column align-items-center mb-2">
											<div class="text-primary font-weight-bold h4">Agustus</div>
											<div class=" h6"><?= $tahun1 ?></div>
										</div>
										<button class="btn btn-primary" type="submit">Bayar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-2">
						<div class="card">
							<div class="card-body">
								<form action="<?= route('transaksi.pay', ['id' => $siswa->id]) ?>" method="post">
									<input type="hidden" name="month" value="9">
									<input type="hidden" name="year" value="<?= $tahun1 ?>">
									<div class="d-flex flex-column align-items-center">
										<div class="d-flex flex-column align-items-center mb-2">
											<div class="text-primary font-weight-bold h4">September</div>
											<div class=" h6"><?= $tahun1 ?></div>
										</div>
										<button class="btn btn-primary" type="submit">Bayar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-2">
						<div class="card">
							<div class="card-body">
								<form action="<?= route('transaksi.pay', ['id' => $siswa->id]) ?>" method="post">
									<input type="hidden" name="month" value="10">
									<input type="hidden" name="year" value="<?= $tahun1 ?>">
									<div class="d-flex flex-column align-items-center">
										<div class="d-flex flex-column align-items-center mb-2">
											<div class="text-primary font-weight-bold h4">Oktober</div>
											<div class=" h6"><?= $tahun1 ?></div>
										</div>
										<button class="btn btn-primary" type="submit">Bayar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-2">
						<div class="card">
							<div class="card-body">
								<form action="<?= route('transaksi.pay', ['id' => $siswa->id]) ?>" method="post">
									<input type="hidden" name="month" value="11">
									<input type="hidden" name="year" value="<?= $tahun1 ?>">
									<div class="d-flex flex-column align-items-center">
										<div class="d-flex flex-column align-items-center mb-2">
											<div class="text-primary font-weight-bold h4">November</div>
											<div class=" h6"><?= $tahun1 ?></div>
										</div>
										<button class="btn btn-primary" type="submit">Bayar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-2">
						<div class="card">
							<div class="card-body">
								<form action="<?= route('transaksi.pay', ['id' => $siswa->id]) ?>" method="post">
									<input type="hidden" name="month" value="12">
									<input type="hidden" name="year" value="<?= $tahun1 ?>">
									<div class="d-flex flex-column align-items-center">
										<div class="d-flex flex-column align-items-center mb-2">
											<div class="text-primary font-weight-bold h4">Desember</div>
											<div class=" h6"><?= $tahun1 ?></div>
										</div>
										<button class="btn btn-primary" type="submit">Bayar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>