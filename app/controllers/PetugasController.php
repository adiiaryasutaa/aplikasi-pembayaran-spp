<?php

namespace App\Controller;

use App\Model\Petugas;
use App\View\Layout\Dashboard;
use Core\Http\Controller;

class PetugasController extends Controller
{
	public function index()
	{
		if (auth()->guest()) {
			return redirect('login');
		}

		return view('petugas/index', ['petugas' => (new Petugas)->all()])
			->useLayout(new Dashboard());
	}
}