<?php if (session()->hasFlash('create-siswa-success')): ?>
	<div class="alert alert-success" role="alert">
		<?= session()->getFlash('create-siswa-success') ?>
	</div>
<?php endif ?>

<?php if (session()->hasFlash('create-siswa-failed')): ?>
	<div class="alert alert-danger" role="alert">
		<?= session()->getFlash('create-siswa-failed') ?>
	</div>
<?php endif ?>

<?php if (session()->hasFlash('delete-siswa-success')): ?>
	<div class="alert alert-success" role="alert">
		<?= session()->getFlash('delete-siswa-success') ?>
	</div>
<?php endif ?>

<div class="card shadow mb-4">
	<div class="card-header d-flex justify-content-between align-items-center py-3">
		<h5 class="m-0 font-weight-bold text-primary">Siswa</h5>
		<button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Tambah</button>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Nis</th>
						<th>Nama</th>
						<th>Kelas</th>
						<th>Jurusan</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($siswa as $s): ?>
						<tr>
							<td><?= $s->nis ?></td>
							<td><?= $s->nama ?></td>
							<td><?= $s->kelas->nama ?></td>
							<td><?= $s->kelas->kompetensi_keahlian ?></td>
							<td>
								<a href="<?= route('siswa.show', ['id' => $s->id]) ?>" class="btn btn-primary">Detail</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="iushj" aria-hidden="true">
	<form action="<?= route('siswa.create') ?>" method="post">
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
											value="<?= old('nisn') ?>">
										<?php if (session()->hasError('nisn')): ?>
											<small class="form-text text-danger"><?= error('nisn') ?></small>
										<?php endif; ?>
									</div>
								</div>
								<div class="col-5">
									<div class="form-group mb-4">
										<label for="nis">NIS</label>
										<input id="nis" name="nis" type="text" class="form-control bg-light border border-primary small"
											value="<?= old('nis') ?>">

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
											value="<?= old('nama') ?>">

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
											class="form-control bg-light border border-primary small"><?= old('alamat') ?></textarea>

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
											class="form-control bg-light border border-primary small" value="<?= old('nomor-telepon') ?>">

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
												<option value="<?= $k->id ?>" <?= old('kelas') == $k->id ? 'selected' : '' ?>>
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
											class="form-control bg-light border border-primary small" value="<?= old('username') ?>">

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
												<option value="<?= $p->id ?>" <?= old('pembayaran') == $p->id ? 'selected' : '' ?>>
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
					<button type="submit" class="btn btn-primary">Tambah</submit>
				</div>
			</div>
		</div>
	</form>
</div>