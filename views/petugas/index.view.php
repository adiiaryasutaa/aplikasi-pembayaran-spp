<?php if (session()->has('create-petugas-success')): ?>
	<div class="alert alert-success" role="alert">
		<?= session('create-petugas-success') ?>
	</div>
<?php endif ?>

<?php if (session()->has('create-petugas-failed')): ?>
	<div class="alert alert-success" role="alert">
		<?= session('create-petugas-failed') ?>
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
						<th>Role</th>
						<th>Username</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($petugas as $p): ?>
						<tr>
							<td><?= $p->nama ?></td>
							<td><span
									class="<?= $p->pengguna->isAdmin() ? 'bg-danger' : 'bg-info' ?> py-1 px-2 rounded text-white font-weight-bolder"><?= $p->pengguna->isAdmin() ? 'ADMIN' : 'PETUGAS' ?></span>
							</td>
							<td><?= $p->pengguna->username ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<form action="<?= route('add.petugas') ?>" method="post">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Tambah Petugas</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group mb-4">
						<label for="name">Nama</label>
						<input id="name" name="nama" type="text" class="form-control bg-light border border-primary small">
					</div>
					<div class="form-group mb-4">
						<label for="username">Username</label>
						<input id="username" name="username" type="text" class="form-control bg-light border border-primary small">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input id="password" name="password" type="password"
							class="form-control bg-light border border-primary small">
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