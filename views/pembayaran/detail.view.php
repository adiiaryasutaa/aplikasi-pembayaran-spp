<?php if (session()->hasFlash('update-pembayaran-success')): ?>
	<div class="alert alert-success" role="alert">
		<?= session()->getFlash('update-pembayaran-success') ?>
	</div>
<?php endif ?>

<?php if (session()->hasError('update-pembayaran-failed')): ?>
	<div class="alert alert-danger" role="alert">
		<?= error('update-pembayaran-failed') ?>
	</div>
<?php endif ?>

<?php if (session()->hasError('delete-pembayaran-failed')): ?>
	<div class="alert alert-danger" role="alert">
		<?= error('delete-pembayaran-failed') ?>
	</div>
<?php endif ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Pembayaran <?= $pembayaran->tahun_ajaran ?></h1>
	<div class="">
		<button class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit</button>
		<button class="btn btn-primary" data-toggle="modal" data-target="#deleteModal">Hapus</button>
	</div>
</div>

<div class="card mb-4">
	<div class="card-header d-flex justify-content-between align-items-center py-3">
		<h5 class="m-0 font-weight-bold text-primary">Tentang Pembayaran</h5>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col">
				Tahun ajaran
			</div>
			<div class="col-10">
				: <?= $pembayaran->tahun_ajaran ?>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col">
				Nominal
			</div>
			<div class="col-10">
				: <?="Rp " . number_format($pembayaran->nominal, 2, ',', '.') ?>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col">
				Total siswa dengan pembayaran ini
			</div>
			<div class="col-10">
				: <?= $pembayaran->total_siswa ?>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col">
				Total transaksi untuk pembayaran ini
			</div>
			<div class="col-10">
				: <?= $pembayaran->total_transaksi ?>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="iushj" aria-hidden="true">
	<form action="<?= route('pembayaran.update', ['id' => $pembayaran->id]) ?>" method="post">
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
					<button type="submit" class="btn btn-primary">Edit</submit>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="iushj" aria-hidden="true">
	<form action="<?= route('pembayaran.delete', ['id' => $pembayaran->id]) ?>" method="post">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="iushj">Hapus Pembayaran <?= $pembayaran->tahun_ajaran ?></h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					Apakah Anda yakin ingin menghapus pembayaran <?= $pembayaran->tahun_ajaran ?>? Semua data transaksi untuk
					pembayaran ini akan juga terhapus
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