<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
		<div class="sidebar-brand-icon rotate-n-15">
			<i class="fas fa-laugh-wink"></i>
		</div>
		<div class="sidebar-brand-text mx-3">SPP Admin</div>
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<!-- Nav Item - Dashboard -->
	<li class="nav-item <?= routeIs('dashboard') ? 'active' : '' ?>">
		<a class="nav-link" href="<?= route('dashboard') ?>">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Dashboard</span></a>
	</li>

	<!-- Divider -->
	<hr class="sidebar-divider">

	<!-- Heading -->
	<div class="sidebar-heading">
		Transaksi
	</div>

	<?php if (!auth()->user()->pengguna->isSiswa()): ?>
		<li class="nav-item >">
			<a class="nav-link" href="/">
				<i class="fas fa-fw fa-moon"></i>
				<span>Transaksi</span></a>
		</li>
	<?php endif; ?>

	<?php if (auth()->user()->pengguna->isAdmin()): ?>
		<li class="nav-item <?= routeIs('pembayaran') ? 'active' : '' ?>">
			<a class="nav-link" href="<?= route('pembayaran') ?>">
				<i class="fas fa-fw fa-sink"></i>
				<span>Pembayaran</span></a>
		</li>
	<?php endif; ?>

	<li class="nav-item">
		<a class="nav-link" href="index.html">
			<i class="fas fa-fw fa-history"></i>
			<span>Riwayat</span></a>
	</li>

	<?php if (auth()->user()->pengguna->isAdmin()): ?>
		<li class="nav-item">
			<a class="nav-link" href="index.html">
				<i class="fas fa-fw fa-file"></i>
				<span>Laporan</span></a>
		</li>
	<?php endif; ?>

	<?php if (!auth()->user()->pengguna->isSiswa()): ?>
		<!-- Divider -->
		<hr class="sidebar-divider">

		<!-- Heading -->
		<div class="sidebar-heading">
			Sekolah
		</div>

	<?php endif; ?>

	<?php if (auth()->user()->pengguna->isAdmin()): ?>
		<li class="nav-item <?= routeIs('siswa') ? 'active' : '' ?>">
			<a class="nav-link" href="<?= route('siswa') ?>">
				<i class="fas fa-fw fa-child"></i>
				<span>Siswa</span></a>
		</li>
	<?php endif; ?>

	<?php if (!auth()->user()->pengguna->isSiswa()): ?>
		<li class="nav-item <?= routeIs('kelas') ? 'active' : '' ?>">
			<a class="nav-link" href="<?= route('kelas') ?>">
				<i class="fas fa-fw fa-house-user"></i>
				<span>Kelas</span></a>
		</li>
	<?php endif; ?>

	<?php if (auth()->user()->pengguna->isAdmin()): ?>
		<li class="nav-item  <?= routeIs('petugas') ? 'active' : '' ?>">
			<a class="nav-link" href="<?= route('petugas') ?>">
				<i class="fas fa-fw fa-user"></i>
				<span>Petugas</span></a>
		</li>
	<?php endif; ?>

	<?php if (auth()->user()->pengguna->isAdmin()): ?>
		<!-- Divider -->
		<hr class="sidebar-divider">

		<!-- Heading -->
		<div class="sidebar-heading">
			User
		</div>

		<li class="nav-item  ">
			<a class="nav-link" href="index.html">
				<i class="fas fa-fw fa-user"></i>
				<span>Pengguna</span></a>
		</li>
	<?php endif; ?>
</ul>