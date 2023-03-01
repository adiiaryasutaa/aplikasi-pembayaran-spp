<?php if (session()->hasFlash('create-petugas-success')): ?>
	<div class="alert alert-success" role="alert">
		<?= session()->getFlash('create-petugas-success') ?>
	</div>
<?php endif ?>

<?php if (session()->hasFlash('create-petugas-failed')): ?>
	<div class="alert alert-danger" role="alert">
		<?= session()->getFlash('create-petugas-failed') ?>
	</div>
<?php endif ?>

<?php if (session()->hasFlash('delete-petugas-success')): ?>
	<div class="alert alert-success" role="alert">
		<?= session()->getFlash('delete-petugas-success') ?>
	</div>
<?php endif ?>

<div class="card shadow mb-4">
	<div class="card-header d-flex justify-content-between align-items-center py-3">
		<h5 class="m-0 font-weight-bold text-primary">Petugas</h5>
		<button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Tambah</button>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Nama</th>
						<th>Username</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($petugas as $p): ?>
						<tr>
							<td><?= $p->nama ?></td>
							<td><?= $p->pengguna->username ?></td>
							<td>
								<a href="<?= route('petugas.show', ['username' => $p->pengguna->username]) ?>"
									class="btn btn-primary">Detail</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="iushj" aria-hidden="true">
	<form action="<?= route('petugas.create') ?>" method="post">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="iushj">Tambah Petugas</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group mb-4">
						<label for="nama">Nama</label>
						<input id="nama" name="nama" type="text" class="form-control bg-light border border-primary small"
							value="<?= old('nama') ?>" required>

						<?php if (session()->hasError('nama')): ?>
							<small class="form-text text-danger"><?= error('nama') ?></small>
						<?php endif; ?>

					</div>
					<div class="form-group mb-4">
						<label for="username">Username</label>
						<input id="username" name="username" type="text" class="form-control bg-light border border-primary small"
							value="<?= old('username') ?>" required>

						<?php if (session()->hasError('username')): ?>
							<small class="form-text text-danger"><?= error('username') ?></small>
						<?php endif; ?>

					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input id="password" name="password" type="password"
							class="form-control bg-light border border-primary small" required>

						<?php if (session()->hasError('password')): ?>
							<small class="form-text text-danger"><?= error('password') ?></small>
						<?php endif; ?>

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