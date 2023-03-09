<?php

namespace App\Controller;

use App\View\Layout\Dashboard;
use Core\Foundation\Facade\DB;
use Core\Http\Controller;

class DashboardController extends Controller
{
	public function index()
	{
		if (auth()->guest()) {
			return redirect('login');
		}

		$data = [
			'pengguna' => auth()->user(),
			'model' => auth()->getWhoUsePengguna(),
		];

		if ($data['pengguna']->isAdmin()) {
			$data['totalTransaksiToday'] = DB::result(
				"SELECT COUNT(transaksi.id) AS total FROM transaksi WHERE DATE(tanggal_dibayar) = CURDATE()"
			)['total'];

			$data['totalTransaksiThisMonth'] = DB::result(
				"SELECT COUNT(transaksi.id) AS total FROM transaksi WHERE MONTH(tanggal_dibayar) = MONTH(CURRENT_DATE())"
			)['total'];
		} else if ($data['pengguna']->isPetugas()) {

		} else {
			$status = DB::result(
				"SELECT 1 FROM transaksi INNER JOIN siswa ON transaksi.siswa_id = siswa.id WHERE siswa.nis = :nis AND siswa.pembayaran_id = transaksi.pembayaran_id AND transaksi.bulan_dibayar = MONTH(CURRENT_DATE())",
				['nis' => $data['model']->nis]
			);

			$data['sppStatus'] = empty($status) ? 0 : 1;
		}

		return view('dashboard/index')
			->with($data)
			->useLayout(new Dashboard('Dashboard'));
	}
}