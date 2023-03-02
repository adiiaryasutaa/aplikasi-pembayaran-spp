<?php

namespace App\Controller;

use App\Model\Petugas;
use App\Model\Siswa;
use App\View\Layout\Dashboard;
use Core\Http\Controller;

class DashboardController extends Controller
{
	public function index()
	{
		if (auth()->guest()) {
			return redirect('login');
		}

		$pengguna = auth()->user();
		$model = auth()->getWhoUsePengguna();

		return view('dashboard/index')
			->with(compact('pengguna', 'model'))
			->useLayout(new Dashboard());
	}
}