<div class="card shadow mb-4">
	<div class="card-header d-flex justify-content-between align-items-center py-3">
		<h5 class="m-0 font-weight-bold text-primary">Pengguna</h5>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Username</th>
						<th>Role</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($pengguna as $p): ?>
						<tr>
							<td><?= $p->username ?></td>
							<td>
								<span class="text-white px-2 py-1 font-weight-bold rounded bg-<?php
								if ($p->isAdmin()) {
									echo 'danger';
								} else if ($p->isPetugas()) {
									echo 'warning';
								} else {
									echo 'info';
								}
								?>">
									<?= $p->role->name ?>
								</span>
							</td>
							<td>
								<?php if (!$p->isAdmin()): ?>
									<a href="<?= route('pengguna.show', ['username' => $p->username]) ?>" class="btn btn-primary">Detail</a>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>