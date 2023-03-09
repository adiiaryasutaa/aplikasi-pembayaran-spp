<?php

namespace App\Controller;

use App\Model\Petugas;
use App\Model\Siswa;
use App\View\Layout\Dashboard;
use Core\Http\Controller;
use App\Model\Transaksi;

class HistoryController extends Controller
{
	public function index()
	{
		$user = auth()->user();

		$transaksi = new Transaksi;

		if ($user->isAdmin()) {
			$histories = $transaksi->allHistoryForAdmin();
		} else if ($user->isPetugas()) {
			$petugas = (new Petugas)->withPenggunaWhereFirst(['pengguna.id' => $user->id]);
			$histories = $transaksi->allHistoryForPetugas(['transaksi.petugas_id' => $petugas->id]);
		} else {
			$siswa = (new Siswa)->getDetailWhereFirst(['pengguna.id' => $user->id]);
			$histories = $transaksi->allHistoryForSiswa(['transaksi.siswa_id' => $siswa->id]);
		}

		return view('history/index')
			->with(compact('histories', 'user'))
			->useLayout(new Dashboard('History'));
	}
}