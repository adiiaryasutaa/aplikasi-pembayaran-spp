<?php

namespace App\Controller;

use App\Model\Siswa;
use App\Model\Petugas;
use App\Model\Transaksi;
use App\View\Layout\Dashboard;
use Core\Http\Controller;

class TransaksiController extends Controller
{
	public function index()
	{
		$data = [];

		if (!is_null($nis = $this->request()->query('nis'))) {
			$data['siswa'] = $siswa = (new Siswa)->whereFirst(compact('nis'));

			if ($siswa->exists()) {
				$siswa->getAllCurrentTraksaksi();

				$data['paidOffMonths'] = [];

				foreach ($siswa->transaksi as $transaksi) {
					$data['paidOffMonths'][] = $transaksi->bulan_dibayar;
				}
			}
		}

		return view('transaksi/index')
			->with($data)
			->useLayout(new Dashboard);
	}

	public function pay(int $id)
	{
		$siswa = (new Siswa)->whereFirst(['siswa.id' => $id]);
		$petugas = (new Petugas)->withPenggunaWhereFirst(['pengguna.id' => auth()->user()->id]);

		$data = [
			'bulan_dibayar' => $this->request('month'),
			'tahun_dibayar' => $this->request('year'),
			'siswa_id' => $siswa->id,
			'petugas_id' => $petugas->id,
			'pembayaran_id' => $siswa->pembayaran_id,
		];

		return (new Transaksi)->insert($data) ? 
			back()->with(['transaksi-success' => 'Proses transaksi sukses']) :
			back()->with(['transaksi-failed' => 'Proses transaksi gagal']);
	}
}