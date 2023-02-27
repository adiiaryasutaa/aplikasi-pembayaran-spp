<?php if (session()->hasFlash('create-kelas-success')): ?>
	<div class="alert alert-success" role="alert">
		<?= session()->getFlash('create-kelas-success') ?>
	</div>
<?php endif ?>

<?php if (session()->hasFlash('create-kelas-failed')): ?>
	<div class="alert alert-success" role="alert">
		<?= session()->getFlash('create-kelas-failed') ?>
	</div>
<?php endif ?>

<div class="card shadow mb-4">
	<div class="card-header d-flex justify-content-between align-items-center py-3">
		<h5 class="m-0 font-weight-bold text-primary">Kelas</h5>
		<button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Tambah</button>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Nama</th>
						<th>Kompetensi Keahlian</th>
						<th>Total Siswa</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($kelas as $k): ?>
						<tr>
							<td><?= $k->nama ?></td>
							<td><?= $k->kompetensi_keahlian ?></td>
							<td><?= $k->total_siswa ?></td>
							<td>
								<a href="<?= route('kelas.show', ['id' => $k->id]) ?>" class="btn btn-primary">Detail</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="iushj" aria-hidden="true">
	<form action="<?= route('kelas.create') ?>" method="post">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="iushj">Tambah Kelas</h5>
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
						<label for="kompetensi-keahlian">Kompetensi Keahlian</label>
						<input id="kompetensi-keahlian" name="kompetensi-keahlian" type="text"
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