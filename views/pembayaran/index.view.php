<?php if (session()->hasFlash('create-pembayaran-success')): ?>
	<div class="alert alert-success" role="alert">
		<?= session()->getFlash('create-pembayaran-success') ?>
	</div>
<?php endif ?>

<?php if (session()->hasFlash('create-pembayaran-failed')): ?>
	<div class="alert alert-danger" role="alert">
		<?= session()->getFlash('create-pembayaran-failed') ?>
	</div>
<?php endif ?>

<?php if (session()->hasFlash('delete-pembayaran-success')): ?>
	<div class="alert alert-success" role="alert">
		<?= session()->getFlash('delete-pembayaran-success') ?>
	</div>
<?php endif ?>

<div class="card shadow mb-4">
	<div class="card-header d-flex justify-content-between align-items-center py-3">
		<h5 class="m-0 font-weight-bold text-primary">Pembayaran</h5>
		<button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Tambah</button>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Tahun Ajaran</th>
						<th>Nominal</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($pembayaran as $p): ?>
						<tr>
							<td><?= $p->tahun_ajaran ?></td>
							<td><?="Rp " . number_format($p->nominal, 2, ',', '.') ?></td>
							<td>
								<a href="<?= route('pembayaran.show', ['id' => $p->id]) ?>" class="btn btn-primary">Detail</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="iushj" aria-hidden="true">
	<form action="<?= route('pembayaran.create') ?>" method="post">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="iushj">Tambah Pembayaran</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group mb-4">
						<label for="tahun-ajaran-1">Tahun Ajaran</label>
						<div class="row align-items-center">
							<div class="col">
								<input id="tahun-ajaran-1" name="tahun-ajaran-1" type="text"
									class="form-control bg-light border border-primary small" value="<?= old('tahun-ajaran-1') ?>">
							</div>
							<div>/</div>
							<div class="col">
								<input id="tahun-ajaran-2" name="tahun-ajaran-2" type="text"
									class="form-control bg-light border border-primary small" value="<?= old('tahun-ajaran-2') ?>">
							</div>
						</div>
						<?php if (session()->hasError('tahun-ajaran-1') || session()->hasError('tahun-ajaran-2')): ?>
							<small class="form-text text-danger">
								<?= error('tahun-ajaran-1') ?>
							</small>
						<?php endif; ?>
					</div>
					<div class="form-group mb-4">
						<label for="nominal">Nominal (tanpa titik)</label>
						<div class="d-flex align-items-center">
							<div class="pr-2">Rp</div>
							<div class="flex-grow-1">
								<input id="nominal" name="nominal" type="text" class="form-control bg-light border border-primary small"
									value="<?= old('nominal') ?>">
							</div>
						</div>
						<?php if (session()->hasError('nominal')): ?>
							<small class="form-text text-danger">
								<?= error('nominal') ?>
							</small>
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

