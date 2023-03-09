<?php

namespace App\Controller;

use App\Model\Pengguna;
use App\Model\Petugas;
use App\Model\Siswa;
use App\View\Layout\Dashboard;
use Core\Http\Controller;

class PenggunaController extends Controller
{
	public function index()
	{
		$pengguna = (new Pengguna)->all();

		return view('pengguna/index')
			->with(compact('pengguna'))
			->useLayout(new Dashboard('Pengguna'));
	}

	public function show(string $username)
	{
		$pengguna = (new Pengguna)->whereFirst(compact('username'));

		if (!$pengguna->exists()) {
			return notFound();
		}

		if ($pengguna->isPetugas()) {
			$petugas = (new Petugas)->whereFirst(['pengguna_id' => $pengguna->id]);

			return redirect(route('petugas.show', ['id' => $petugas->id]));
		}

		$siswa = (new Siswa)->whereFirst(['pengguna_id' => $pengguna->id]);

		return redirect(route('siswa.show', ['id' => $siswa->id]));
	}
}