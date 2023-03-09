<?php

namespace App\Controller;

use App\View\Layout\Dashboard;
use Core\Foundation\Facade\DB;
use Core\Http\Controller;

class LaporanController extends Controller
{
	public function index()
	{
		return view('laporan/index')
			->useLayout(new Dashboard('Laporan'));
	}

	public function generate()
	{
		$result = DB::resultAll("SELECT * FROM transaksi INNER JOIN siswa ON transaksi.siswa_id = siswa.id INNER JOIN petugas ON transaksi.petugas_id = petugas.id WHERE DATE(transaksi.tanggal_dibayar) BETWEEN :from AND :to", [
			'from' => $this->request('from-date'),
			'to' => $this->request('to-date'),
		]);

		return view('laporan/index')
			->with(['transaksi' => $result])
			->useLayout(new Dashboard('Laporan'));
	}
}