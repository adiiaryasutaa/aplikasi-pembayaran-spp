<?php

namespace App\Controller;

use App\Model\Siswa;
use App\Model\Transaksi;
use App\View\Layout\Dashboard;
use COre\Foundation\Facade\Session;
use Core\Http\Controller;

class TransaksiController extends Controller
{
	public function index()
	{
		$data = [];

		if (!is_null($nis = $this->request()->query('nis'))) {
			$data['siswa'] = (new Siswa)->getDetailTransaksiWhere(['nis' => $nis]);
		}

		return view('transaksi/index')
			->with($data)
			->useLayout(new Dashboard);
	}

	public function pay(int $id)
	{
		$siswa = (new Siswa)->getDetailTransaksiWhere(['siswa.id' => $id]);

		$data = [
			'bulan_dibayar' => $this->request('month'),
			'tahun_dibayar' => $this->request('year'),
			'siswa_id' => $siswa->id,
			'petugas_id' => auth()->user()->id,
			'pembayaran_id' => $siswa->pembayaran->id,
		];

		if ((new Transaksi)->insert($data)) {
			return back();
		}

		return "Hehe";
	}
}