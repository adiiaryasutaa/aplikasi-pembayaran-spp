<?php if (session()->hasFlash('delete-petugas-failed')): ?>
	<div class="alert alert-danger" role="alert">
		<?= session()->getFlash('delete-petugas-failed') ?>
	</div>
<?php endif ?>

<?php if (session()->hasFlash('update-petugas-success')): ?>
	<div class="alert alert-success" role="alert">
		<?= session()->getFlash('update-petugas-success') ?>
	</div>
<?php endif ?>

<?php if (session()->hasFlash('update-petugas-canceled')): ?>
	<div class="alert alert-info" role="alert">
		<?= session()->getFlash('update-petugas-canceled') ?>
	</div>
<?php endif ?>

<?php if (session()->hasFlash('update-petugas-failed')): ?>
	<div class="alert alert-danger" role="alert">
		<?= session()->getFlash('update-petugas-failed') ?>
	</div>
<?php endif ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><?= $petugas->nama ?></h1>
	<div class="">
		<button class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit</button>
		<button class="btn btn-primary" data-toggle="modal" data-target="#deleteModal">Hapus</button>
	</div>
</div>

<div class="card mb-4">
	<div class="card-header d-flex justify-content-between align-items-center py-3">
		<h5 class="m-0 font-weight-bold text-primary">Tentang Petugas</h5>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col">
				Nama
			</div>
			<div class="col-10">
				: <?= $petugas->nama ?>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col">
				Total transaksi
			</div>
			<div class="col-10">
				: <?= $petugas->getTotalTransaksi() ?>
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
				: <?= $petugas->pengguna->username ?>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col">
				Role
			</div>
			<div class="col-10">
				: <span class="bg-info px-2 py-1 rounded text-white font-weight-bold text-uppercase">Petugas</span>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="iushj" aria-hidden="true">
	<form action="<?= route('petugas.update', ['username' => $petugas->pengguna->username]) ?>" method="post">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="iushj">Edit <span class="text-primary"><?= $petugas->nama ?></span></h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group mb-4">
						<label for="name">Nama</label>
						<input id="name" name="nama" type="text" class="text-dark form-control bg-light border border-primary small"
							placeholder="<?= $petugas->nama ?>" value="<?= $petugas->nama ?>">
					</div>
					<div class="form-group mb-4">
						<label for="username">Username</label>
						<input id="username" name="username" type="text" class="form-control bg-light border border-primary small"
							placeholder="<?= $petugas->pengguna->username ?>" value="<?= $petugas->pengguna->username ?>">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input id="password" name="password" type="password"
							class="form-control bg-light border border-primary small">
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
	<form action="<?= route('petugas.delete', ['username' => $petugas->pengguna->username]) ?>" method="post">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="iushj">Hapus <?= $petugas->nama ?></h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					Apakah Anda yakin ingin menghapus <?= $petugas->nama ?>? Semua data transaksi yang dilakukannya akan berubah menjadi "Tidak diketahui"
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="reset" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Hapus</submit>
				</div>
			</div>
		</div>
	</form>
</div>