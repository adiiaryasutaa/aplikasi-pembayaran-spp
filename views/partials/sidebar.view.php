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

	<li class="nav-item  ">
		<a class="nav-link" href="index.html">
			<i class="fas fa-fw fa-money-bill"></i>
			<span>Transaksi</span></a>
	</li>

	<li class="nav-item  ">
		<a class="nav-link" href="index.html">
			<i class="fas fa-fw fa-sink"></i>
			<span>Pembayaran</span></a>
	</li>

	<li class="nav-item  ">
		<a class="nav-link" href="index.html">
			<i class="fas fa-fw fa-history"></i>
			<span>Riwayat</span></a>
	</li>

	<li class="nav-item  ">
		<a class="nav-link" href="index.html">
			<i class="fas fa-fw fa-file"></i>
			<span>Laporan</span></a>
	</li>

	<!-- Divider -->
	<hr class="sidebar-divider">

	<!-- Heading -->
	<div class="sidebar-heading">
		Sekolah
	</div>

	<li class="nav-item  ">
		<a class="nav-link" href="index.html">
			<i class="fas fa-fw fa-child"></i>
			<span>Siswa</span></a>
	</li>

	<li class="nav-item  ">
		<a class="nav-link" href="index.html">
			<i class="fas fa-fw fa-house-user"></i>
			<span>Kelas</span></a>
	</li>

	<li class="nav-item  <?= routeIs('petugas') ? 'active' : '' ?>">
		<a class="nav-link" href="<?= route('petugas') ?>">
			<i class="fas fa-fw fa-user"></i>
			<span>Petugas</span></a>
	</li>

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
</ul>