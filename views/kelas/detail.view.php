<?php if (session()->hasFlash('update-kelas-success')): ?>
	<div class="alert alert-success" role="alert">
		<?= session()->getFlash('update-kelas-success') ?>
	</div>
<?php endif ?>

<?php if (session()->hasFlash('update-kelas-canceled')): ?>
	<div class="alert alert-info" role="alert">
		<?= session()->getFlash('update-kelas-canceled') ?>
	</div>
<?php endif ?>

<?php if (session()->hasFlash('update-kelas-failed')): ?>
	<div class="alert alert-danger" role="alert">
		<?= session()->getFlash('update-kelas-failed') ?>
	</div>
<?php endif ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><?= $kelas->nama ?></h1>
	<div class="">
		<button class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit</button>
		<button class="btn btn-primary" data-toggle="modal" data-target="#deleteModal">Hapus</button>
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
				: <?= $kelas->nama ?>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col">
				kompetensi keahlian
			</div>
			<div class="col-10">
				: <?= $kelas->kompetensi_keahlian ?>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col">
				Total siswa
			</div>
			<div class="col-10">
				: <?= $kelas->total_siswa ?>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="iushj" aria-hidden="true">
	<form action="<?= route('kelas.update', ['id' => $kelas->id]) ?>" method="post">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="iushj">Edit Kelas <span class="text-primary"><?= $kelas->nama ?></span></h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group mb-4">
						<label for="name">Nama</label>
						<input id="name" name="nama" type="text" class="form-control bg-light border border-primary small"
							placeholder="<?= $kelas->nama ?>" value="<?= $kelas->nama ?>">
					</div>
					<div class="form-group mb-4">
						<label for="kompetensi-keahlian">Kompetensi Keahlian</label>
						<input id="kompetensi-keahlian" name="kompetensi-keahlian" type="text"
							class="form-control bg-light border border-primary small" placeholder="<?= $kelas->kompetensi_keahlian ?>"
							value="<?= $kelas->kompetensi_keahlian ?>">
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