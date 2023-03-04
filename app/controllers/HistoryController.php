<?php

namespace App\Controller;

use App\Model\Siswa;
use App\View\Layout\Dashboard;
use Core\Http\Controller;
use App\Model\Transaksi;

class HistoryController extends Controller
{
	public function index()
	{
		if (($user = auth()->user())->isSiswa()) {
			$siswa = (new Siswa)->getDetailWhereFirst(['pengguna.id' => $user->id]);
			$histories = (new Transaksi)->forHistoryWhere(['transaksi.siswa_id' => $siswa->id]);
		} else {
			$histories = (new Transaksi)->allForHistory();
		}

		return view('history/index')
			->with(compact('histories', 'user'))
			->useLayout(new Dashboard);
	}
}