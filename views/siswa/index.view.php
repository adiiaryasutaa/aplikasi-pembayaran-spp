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
										<input id="nis" name="nis" type="text" class="form-control bg-light border border-primary small">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group mb-4">
										<label for="nama">Nama</label>
										<input id="nama" name="nama" type="text" class="form-control bg-light border border-primary small">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group mb-4">
										<label for="alamat">Alamat</label>
										<textarea id="alamat" name="alamat" type="text"
											class="form-control bg-light border border-primary small"></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group mb-4">
										<label for="nomor-telepon">Nomor Telepon</label>
										<input id="nomor-telepon" name="nomor-telepon" type="text"
											class="form-control bg-light border border-primary small">
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
											<option>Belum dipilih</option>
											<?php foreach ($kelas as $k): ?>
												<option value="<?= $k->id ?>"><?= $k->nama ?></option>
											<?php endforeach; ?>
										</select>
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
											class="form-control bg-light border border-primary small">
									</div>

									<div class="form-group mb-4">
										<label for="password">Password</label>
										<input id="password" name="password" type="password"
											class="form-control bg-light border border-primary small">
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
											<option>Tidak ada</option>
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
											<option>5</option>
										</select>
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

<script>
	$('#addModal').modal('show')
</script>
<?php if (session()->has('continue')): ?>
<?php endif; ?>