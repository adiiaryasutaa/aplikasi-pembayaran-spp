<?php

namespace App\Controller;

use App\Model\Petugas;
use App\View\Layout\Dashboard;
use Core\Http\Controller;

class PetugasController extends Controller
{
	public function index()
	{
		$petugas = new Petugas();
		$petugas->where(['id' => 1]);

		return view('petugas/index', ['petugas' => $petugas])
			->useLayout(new Dashboard());
	}
}