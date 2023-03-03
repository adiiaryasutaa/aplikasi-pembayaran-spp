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
			$histories = (new Siswa)
				->getDetailWhereFirst(['pengguna.id' => $user->id])
				->getTransaksiHistories();
		} else {
			$histories = (new Transaksi)->allForHistory();
		}

		dd($histories);

		return view('history/index')
			->with(compact('histories'))
			->useLayout(new Dashboard);
	}
}