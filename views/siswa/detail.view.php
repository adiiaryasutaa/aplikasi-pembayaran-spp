<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><?= $siswa->nis ?> / <?= $siswa->kelas->nama ?> / <?= $siswa->nama ?></h1>
	<div class="">
		<button class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit</button>
		<button class="btn btn-primary" data-toggle="modal" data-target="#deleteModal">Hapus</button>
	</div>
</div>

<div class="card mb-4">
	<div class="card-header d-flex justify-content-between align-items-center py-3">
		<h5 class="m-0 font-weight-bold text-primary">Tentang Siswa</h5>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col">
				NISN
			</div>
			<div class="col-10">
				: <?= $siswa->nisn ?>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col">
				NIS
			</div>
			<div class="col-10">
				: <?= $siswa->nis ?>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col">
				Nama
			</div>
			<div class="col-10">
				: <?= $siswa->nama ?>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col">
				Alamat
			</div>
			<div class="col-10">
				: <?= $siswa->alamat ?>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col">
				Nomor telepon
			</div>
			<div class="col-10">
				: <?= $siswa->telepon ?>
			</div>
		</div>
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
				: <?= $siswa->kelas->nama ?>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col">
				Kompetensi Keahlian
			</div>
			<div class="col-10">
				: <?= $siswa->kelas->kompetensi_keahlian ?>
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
				: <?= $siswa->pengguna->username ?>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col">
				Role
			</div>
			<div class="col-10">
				: <?= $siswa->pengguna->role->name ?>
			</div>
		</div>
	</div>
</div>

<div class="card mb-4">
	<div class="card-header d-flex justify-content-between align-items-center py-3">
		<h5 class="m-0 font-weight-bold text-primary">Tentang Pembayaran</h5>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col">
				Tahun Ajaran
			</div>
			<div class="col-10">
				: <?= $siswa->pembayaran->tahun_ajaran ?>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col">
				Nominal
			</div>
			<div class="col-10">
				: <?= "Rp " . number_format($siswa->pembayaran->nominal, 2, ',', '.') ?>
			</div>
		</div>
	</div>
</div>