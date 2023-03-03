<?php

namespace App\Model;

use Core\Database\Model;

class Transaksi extends Model
{
	protected string $table = 'transaksi';

	public function allForHistory()
	{
		$query = sprintf(
			"SELECT %s FROM %s INNER JOIN %s ON %s INNER JOIN %s ON %s INNER JOIN %s ON %s ORDER BY %s DESC",
			'transaksi.id, transaksi.tanggal_dibayar, transaksi.bulan_dibayar, transaksi.tahun_dibayar, pembayaran.id AS pembayaranId, pembayaran.tahun_ajaran, siswa.id AS siswaId, siswa.nis, petugas.id AS petugasId, petugas.nama',
			'transaksi', 'pembayaran', 'pembayaran.id = transaksi.pembayaran_id', 'siswa', 'siswa.id = transaksi.siswa_id', 'petugas', 'petugas.id = transaksi.petugas_id', 'transaksi.tanggal_dibayar'
		);

		$result = $this->connection->resultAll($query);

		$data = [];

		foreach ($result as $d) {
			$data[] = [
				'id' => $d['id'],
				'tanggal_dibayar' => $d['tanggal_dibayar'],
				'bulan_dibayar' => $d['bulan_dibayar'],
				'tahun_dibayar' => $d['tahun_dibayar'],
				'pembayaran' => new Pembayaran([
					'id' => $d['pembayaranId'],
					'tahun_ajaran' => $d['tahun_ajaran'],
				]),
				'siswa' => new Siswa([
					'id' => $d['siswaId'],
					'nis' => $d['nis'],
				]),
				'petugas' => new Petugas([
					'id' => $d['petugasId'],
					'nama' => $d['nama'],
				]),
			];
		}

		return is_array($models = $this->make($data)) ? $models : [$models];
	}
}