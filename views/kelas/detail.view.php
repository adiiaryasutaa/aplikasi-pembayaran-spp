<?php if (session()->hasFlash('update-kelas-success')): ?>
	<div class="alert alert-success" role="alert">
		<?= session()->getFlash('update-kelas-success') ?>
	</div>
<?php endif ?>

<?php if (session()->hasFlash('update-kelas-failed')): ?>
	<div class="alert alert-danger" role="alert">
		<?= session()->getFlash('update-kelas-failed') ?>
	</div>
<?php endif ?>

<?php if (session()->hasFlash('delete-kelas-failed')): ?>
	<div class="alert alert-danger" role="alert">
		<?= session()->getFlash('delete-kelas-failed') ?>
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
							value="<?= $kelas->nama ?>" required>
						<?php if (session()->hasError('nama')): ?>
							<small class="form-text text-danger"><?= error('nama') ?></small>
						<?php endif; ?>
					</div>
					<div class="form-group mb-4">
						<label for="kompetensi-keahlian">Kompetensi Keahlian</label>
						<input id="kompetensi-keahlian" name="kompetensi-keahlian" type="text"
							class="form-control bg-light border border-primary small" value="<?= $kelas->kompetensi_keahlian ?>"
							required>
						<?php if (session()->hasError('kompetensi-keahlian')): ?>
							<small class="form-text text-danger"><?= error('kompetensi-keahlian') ?></small>
						<?php endif; ?>
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
	<form action="<?= route('kelas.delete', ['id' => $kelas->id]) ?>" method="post">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="iushj">Hapus Kelas <?= $kelas->nama ?></h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					Apakah Anda yakin ingin menghapus kelas <?= $kelas->nama ?>? Semua siswa yang berada di kelas ini akan juga
					ikut terhapus.
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="reset" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Hapus</submit>
				</div>
			</div>
		</div>
	</form>
</div>

<?php if (session()->getFlash('open-modal')): ?>

	<script type="text/javascript">
		$(window).on('load', function () {
			$('#editModal').modal('show')
		})
	</script>
	
<?php endif; ?>