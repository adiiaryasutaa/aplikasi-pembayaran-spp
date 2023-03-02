<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

	<!-- Sidebar Toggle (Topbar) -->
	<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
		<i class="fa fa-bars"></i>
	</button>

	<!-- Topbar Navbar -->
	<ul class="navbar-nav ml-auto">
		<!-- Nav Item - User Information -->
		<li class="nav-item dropdown no-arrow">
			<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				<span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= auth()->getWhoUsePengguna()->nama ?></span>
				<img class="img-profile rounded-circle" src="<?= asset('img/undraw_profile.svg') ?>">
			</a>
		</li>

		<!-- Logout button -->
		<li class="nav-item d-flex align-items-center">
			<button class="btn btn-outline-primary" data-toggle="modal" data-target="#logoutModal">Keluar</submit>
		</li>
	</ul>

</nav>