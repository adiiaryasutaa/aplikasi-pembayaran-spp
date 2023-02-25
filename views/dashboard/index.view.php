<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Selamat Datang <span class="text-primary"><?= $user->nama ?></span>!</h1>
</div>

<div class="my-5">
	<video autoplay muted>
		<source src="<?= asset('video/dashboard.mp4') ?>" type="video/mp4">
		Your browser does not support the video tag.
	</video>
</div>