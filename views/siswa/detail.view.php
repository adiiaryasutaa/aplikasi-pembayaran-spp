<?php if (session()->hasFlash('update-siswa-success')): ?>
	<div class="alert alert-success" role="alert">
		<?= session()->getFlash('update-siswa-success') ?>
	</div>
<?php endif ?>

<?php if (session()->hasFlash('update-siswa-failed')): ?>
	<div class="alert alert-danger" role="alert">
		<?= session()->getFlash('update-siswa-failed') ?>
	</div>
<?php endif ?>

<?php if (session()->hasFlash('delete-siswa-failed')): ?>
	<div class="alert alert-danger" role="alert">
		<?= session()->getFlash('delete-siswa-failed') ?>
	</div>
<?php endif ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><?= $siswa->nis ?> / <?= $siswa->kelas->nama ?> / <?= $siswa->nama ?></h1>
	<div class="">
		<button class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit</button>
		<button class="btn btn-primary" data-toggle="modal" data-target="#deleteModal">Hapus</button>
	</div>
</div>

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

<div class="card mb-4">
	<div class="card-header d-flex justify-content-between align-items-center py-3">
		<h5 class="m-0 font-weight-bold text-primary">Tentang Kelas</h5>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col">
				Nama
			</div>
			<div class="col-10">
				: <?= $siswa->kelas->nama ?>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col">
				Kompetensi Keahlian
			</div>
			<div class="col-10">
				: <?= $siswa->kelas->kompetensi_keahlian ?>
			</div>
		</div>
	</div>
</div>

<div class="card mb-4">
	<div class="card-header d-flex justify-content-between align-items-center py-3">
		<h5 class="m-0 font-weight-bold text-primary">Tentang Pengguna</h5>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col">
				Username
			</div>
			<div class="col-10">
				: <?= $siswa->pengguna->username ?>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col">
				Role
			</div>
			<div class="col-10">
				: <?= $siswa->pengguna->role->name ?>
			</div>
		</div>
	</div>
</div>

<div class="card mb-4">
	<div class="card-header d-flex justify-content-between align-items-center py-3">
		<h5 class="m-0 font-weight-bold text-primary">Tentang Pembayaran</h5>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col">
				Tahun Ajaran
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

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="iushj" aria-hidden="true">
	<form action="<?= route('siswa.update', ['id' => $siswa->id]) ?>" method="post">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="iushj">Tambah Siswa</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col">
							<div class="row">
								<div class="col">
									<div class="text-dark border-bottom mb-3">
										Informasi Siswa
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-7">
									<div class="form-group mb-4">
										<label for="nisn">NISN</label>
										<input id="nisn" name="nisn" type="text" class="form-control bg-light border border-primary small"
											value="<?= old('nisn', $siswa->nisn) ?>">

										<?php if (session()->hasError('nisn')): ?>
											<small class="form-text text-danger"><?= error('nisn') ?></small>
										<?php endif; ?>

									</div>
								</div>
								<div class="col-5">
									<div class="form-group mb-4">
										<label for="nis">NIS</label>
										<input id="nis" name="nis" type="text" class="form-control bg-light border border-primary small"
											value="<?= old('nis', $siswa->nis) ?>">

										<?php if (session()->hasError('nis')): ?>
											<small class="form-text text-danger"><?= error('nis') ?></small>
										<?php endif; ?>

									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group mb-4">
										<label for="nama">Nama</label>
										<input id="nama" name="nama" type="text" class="form-control bg-light border border-primary small"
											value="<?= old('nama', $siswa->nama) ?>">

										<?php if (session()->hasError('nama')): ?>
											<small class="form-text text-danger"><?= error('nama') ?></small>
										<?php endif; ?>

									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group mb-4">
										<label for="alamat">Alamat</label>
										<textarea id="alamat" name="alamat" type="text"
											class="form-control bg-light border border-primary small"><?= old('alamat', $siswa->alamat) ?></textarea>

										<?php if (session()->hasError('alamat')): ?>
											<small class="form-text text-danger"><?= error('alamat') ?></small>
										<?php endif; ?>

									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group mb-4">
										<label for="nomor-telepon">Nomor Telepon</label>
										<input id="nomor-telepon" name="nomor-telepon" type="text"
											class="form-control bg-light border border-primary small"
											value="<?= old('nomor-telepon', $siswa->telepon) ?>">

										<?php if (session()->hasError('telepon')): ?>
											<small class="form-text text-danger"><?= error('telepon') ?></small>
										<?php endif; ?>

									</div>
								</div>
							</div>

							<div class="row">
								<div class="col">
									<div class="text-dark border-bottom mb-3">
										Informasi Kelas
									</div>

									<div class="form-group">
										<label for="kelas">Kelas</label>
										<select class="form-control bg-light border border-primary small" id="kelas" name="kelas">
											<option value="0">Belum dipilih</option>

											<?php foreach ($kelas as $k): ?>
												<option value="<?= $k->id ?>" <?= old('kelas', $siswa->kelas->id) == $k->id ? 'selected' : '' ?>>
													<?= $k->nama ?>
												</option>
											<?php endforeach; ?>

										</select>

										<?php if (session()->hasError('kelas')): ?>
											<small class="form-text text-danger"><?= error('kelas') ?></small>
										<?php endif; ?>

									</div>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="row">
								<div class="col">
									<div class="text-dark border-bottom mb-3">
										Informasi Pengguna
									</div>

									<div class="form-group mb-4">
										<label for="username">Username</label>
										<input id="username" name="username" type="text"
											class="form-control bg-light border border-primary small"
											value="<?= old('username', $siswa->pengguna->username) ?>">

										<?php if (session()->hasError('username')): ?>
											<small class="form-text text-danger"><?= error('username') ?></small>
										<?php endif; ?>

									</div>

									<div class="form-group mb-4">
										<label for="password">Password</label>
										<input id="password" name="password" type="password"
											class="form-control bg-light border border-primary small">

										<?php if (session()->hasError('password')): ?>
											<small class="form-text text-danger"><?= error('password') ?></small>
										<?php endif; ?>

									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="text-dark border-bottom mb-3">
										Informasi Pembayaran
									</div>

									<div class="form-group">
										<label for="pembayaran">Pembayaran</label>
										<select class="form-control bg-light border border-primary small" id="pembayaran" name="pembayaran">
											<option value="0">Belum dipilih</option>

											<?php foreach ($pembayaran as $p): ?>
												<option value="<?= $p->id ?>" <?= old('pembayaran', $siswa->pembayaran->id) == $p->id ? 'selected' : '' ?>>
													<span><?= $p->tahun_ajaran ?></span>
													<span><?="Rp " . number_format($p->nominal, 2, ',', '.') ?></span>
												</option>
											<?php endforeach; ?>

										</select>

										<?php if (session()->hasError('pembayaran')): ?>
											<small class="form-text text-danger"><?= error('pembayaran') ?></small>
										<?php endif; ?>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="reset" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Perbarui</submit>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="iushj" aria-hidden="true">
	<form action="<?= route('siswa.delete', ['id' => $siswa->id]) ?>" method="post">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="iushj">Hapus <?= $siswa->nama ?></h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					Apakah Anda yakin ingin menghapus <?= $siswa->nama ?>? Semua data transaksi yang dilakukannya akan ikut terhapus
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="reset" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Hapus</submit>
				</div>
			</div>
		</div>
	</form>
</div>