<div class="card shadow mb-4">
	<div class="card-header d-flex justify-content-between align-items-center py-3">
		<h5 class="m-0 font-weight-bold text-primary">History</h5>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Tanggal Waktu</th>
						<th>Bulan Dibayar</th>
						<th>Tahun Dibayar</th>
						<th>Tahun Ajaran</th>

						<?php if (!$user->isSiswa()): ?>
							<th>NIS</th>
						<?php endif; ?>

						<?php if (!$user->isPetugas()): ?>
							<th>Petugas</th>
						<?php endif; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($histories as $transaksi): ?>
						<tr>
							<td><?= date_format(date_create($transaksi->tanggal_dibayar), 'd/m/Y H:m:s') ?></td>
							<td><?= match ($transaksi->bulan_dibayar) {
								1 => 'Januari',
								2 => 'Februari',
								3 => 'Maret',
								4 => 'April',
								5 => 'Mei',
								6 => 'Juni',
								7 => 'Juli',
								8 => 'Agustus',
								9 => 'September',
								10 => 'Oktober',
								11 => 'November',
								12 => 'Desember',
							}
								?></td>
							<td><?= $transaksi->tahun_dibayar ?></td>
							<td>
								<?php if ($user->isAdmin()): ?>
									<a href="<?= route('pembayaran.show', ['id' => $transaksi->pembayaran->id]) ?>">
										<?= $transaksi->pembayaran->tahun_ajaran ?>
									</a>
								<?php else: ?>
									<?= $transaksi->pembayaran->tahun_ajaran ?>
								<?php endif; ?>
							</td>

							<?php if (!$user->isSiswa()): ?>
								<td>
									<?php if ($user->isAdmin()): ?>
										<a href="<?= route('siswa.show', ['id' => $transaksi->siswa->id]) ?>">
											<?= $transaksi->siswa->nis ?>
										</a>
									<?php else: ?>
										<?= $transaksi->siswa->nis ?>
									<?php endif; ?>
								</td>
							<?php endif; ?>

							<?php if (!$user->isPetugas()): ?>
								<td>
									<?php if ($user->isAdmin() && $transaksi->petugas->id !== auth()->user()->id): ?>
										<a href="<?= route('petugas.show', ['id' => $transaksi->petugas->id]) ?>">
											<?= $transaksi->petugas->nama ?>
										</a>
									<?php else: ?>
										<?= $transaksi->petugas->nama ?>
									<?php endif; ?>
								</td>
							<?php endif; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>