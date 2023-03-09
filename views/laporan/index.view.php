<form action="<?= route('laporan.create') ?>" method="get">
	<div class="card mb-4">
		<div class="card-header d-flex justify-content-between align-items-center py-3">
			<h5 class="m-0 font-weight-bold text-primary">Generate Laporan</h5>
			<button class="btn btn-primary" type="submit">Generate</button>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label for="from-date">Dari Tanggal</label>
						<input id="from-date" name="from-date" type="date" class="form-control bg-light border border-primary small"
							value="<?= old('from-date') ?>">
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="to-date">Sampai Tanggal</label>
						<input id="to-date" name="to-date" type="date" class="form-control bg-light border border-primary small"
							value="<?= old('to-date') ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<?php if (request()->hasQuery('from-date') && request()->hasQuery('to-date')): ?>
	<?php print_r($transaksi) ?>
<?php endif ?>