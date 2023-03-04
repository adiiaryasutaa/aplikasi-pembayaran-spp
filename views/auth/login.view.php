<div class="row justify-content-center">

	<div class="col-xl-10 col-lg-12 col-md-9">

		<div class="card o-hidden border-0 shadow-lg my-5">
			<div class="card-body p-0">
				<!-- Nested Row within Card Body -->
				<div class="row">
					<div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
					<div class="col-lg-6">
						<div class="p-5">
							<div class="text-center">
								<h1 class="h4 text-gray-900 mb-4">
									Selamat Datang di
									<div class="text-primary font-weight-bold mt-2">
										Aplikasi Pembayaran SPP
									</div>
								</h1>
							</div>

							<?php if (session()->hasFlash('login-failed')): ?>
								<div class="alert alert-danger" role="alert">
									<?= session('login-failed') ?>
								</div>
							<?php endif; ?>

							<form action="<?= route('login') ?>" method="POST" class="user">
								<div class="form-group">
									<input name="username" type="text"
										class="form-control form-control-user border border-primary small rounded" id="username"
										placeholder="Username" value="<?= old('username') ?>" >
								</div>
								<div class="form-group">
									<input name="password" type="password"
										class="form-control form-control-user border border-primary small rounded" id="password"
										placeholder="Password">
								</div>
								<button type="submit" class="btn btn-primary btn-user btn-block rounded">
									Login
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

</div>