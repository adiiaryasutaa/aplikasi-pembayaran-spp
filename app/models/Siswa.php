<?php

namespace App\Model;

use Core\Database\Model;
use Core\Database\QueryHelper;

class Siswa extends Model
{
	protected string $table = 'siswa';

	public function all()
	{
		$query = sprintf(
			"SELECT %s FROM %s INNER JOIN %s ON %s",
			"$this->table.*, kelas.nama AS nama_kelas, kelas.kompetensi_keahlian",
			$this->table,
			'kelas',
			"$this->table.kelas_id = kelas.id",
		);

		$result = $this->connection->resultAll($query);

		$this->queried();

		$data = [];

		foreach ($result as $d) {
			$kelas = new Kelas([
				'id' => $d['kelas_id'],
				'nama' => $d['nama_kelas'],
				'kompetensi_keahlian' => $d['kompetensi_keahlian'],
			]);

			unset($d['kelas_id'], $d['nama_kelas'], $d['kompetensi_keahlian']);

			$data[] = array_merge($d, compact('kelas'));
		}

		return is_array($models = $this->make($data)) ? $models : [$models];
	}

	public function getDetailWhereFirst(array $columns)
	{
		$values = array_values($columns);
		$columns = array_keys($columns);
		$bindings = QueryHelper::makeColumnBindings($columns);
		$wheres = QueryHelper::makeWheres($bindings);

		$query = sprintf(
			"SELECT %s FROM %s INNER JOIN %s ON %s INNER JOIN %s ON %s INNER JOIN %s ON %s WHERE %s",
			'siswa.*, kelas.nama AS nama_kelas, kelas.kompetensi_keahlian, pengguna.username, pengguna.password, pengguna.role, pembayaran.tahun_ajaran, pembayaran.nominal',
			'siswa',
			'kelas',
			'siswa.kelas_id = kelas.id',
			'pengguna',
			'siswa.pengguna_id = pengguna.id',
			'pembayaran',
			'siswa.pembayaran_id = pembayaran.id',
			$wheres
		);

		$data = $this->connection->result($query, array_combine($bindings, $values));

		$this->queried();

		if ($data) {
			$this->setAttributes([
				'id' => $data['id'],
				'nisn' => $data['nisn'],
				'nis' => $data['nis'],
				'nama' => $data['nama'],
				'alamat' => $data['alamat'],
				'telepon' => $data['telepon'],
				'kelas' => new Kelas([
					'id' => $data['kelas_id'],
					'nama' => $data['nama_kelas'],
					'kompetensi_keahlian' => $data['kompetensi_keahlian'],
				]),
				'pengguna' => new Pengguna([
					'id' => $data['pengguna_id'],
					'username' => $data['username'],
					'password' => $data['password'],
					'role' => $data['role'],
				]),
				'pembayaran' => new Pembayaran([
					'id' => $data['pembayaran_id'],
					'tahun_ajaran' => $data['tahun_ajaran'],
					'nominal' => $data['nominal'],
				]),
			]);
		}

		return $this;
	}

	public function getAllCurrentTraksaksi()
	{
		$columns = ['siswa.id'];
		$values = [$this->id];
		$bindings = QueryHelper::makeColumnBindings($columns);
		$wheres = QueryHelper::makeWheres($bindings);

		$query = sprintf(
			"SELECT %s FROM %s INNER JOIN %s ON %s WHERE %s",
			'siswa.id, nis, nama, pembayaran_id, tahun_ajaran, nominal', 'siswa', 'pembayaran', 'siswa.pembayaran_id = pembayaran.id', $wheres
		);

		$result = $this->connection->result($query, array_combine($bindings, $values));

		$this->queried();

		$this->setAttributes([
			...array_diff_key($result, ['pembayaran_id' => 1, 'nominal' => 1, 'tahun_ajaran' => 1]),
			'pembayaran' => new Pembayaran([
				'id' => $result['pembayaran_id'],
				'tahun_ajaran' => $result['tahun_ajaran'],
				'nominal' => $result['nominal'],
			]),
		]);

		$columns = array_merge($columns, ['transaksi.pembayaran_id']);
		$values = array_merge($values, [$this->pembayaran->id]);
		$bindings = QueryHelper::makeColumnBindings($columns);
		$wheres = QueryHelper::makeWheres($bindings);

		$query = sprintf(
			"SELECT %s FROM %s INNER JOIN %s ON %s WHERE %s",
			'transaksi.id, bulan_dibayar, tahun_dibayar', 'transaksi', 'siswa', 'siswa.id = transaksi.siswa_id', $wheres
		);

		$result = $this->connection->resultAll($query, array_combine($bindings, $values));

		$transaksi = [];

		foreach ($result as $t) {
			$transaksi[] = new Transaksi($t);
		}

		$this->setAttribute('transaksi', $transaksi);

		return $this;
	}

	public function getDetailTransaksiWhere(array $columns)
	{
		$values = array_values($columns);
		$columns = array_keys($columns);
		$bindings = QueryHelper::makeColumnBindings($columns);
		$wheres = QueryHelper::makeWheres($bindings);

		$query = sprintf(
			"SELECT %s FROM %s LEFT JOIN %s ON %s LEFT JOIN %s ON %s LEFT JOIN %s ON %s WHERE %s",
			'siswa.*, transaksi.id AS id_transaksi, transaksi.tanggal_dibayar, transaksi.bulan_dibayar, transaksi.tahun_dibayar, petugas.nama AS nama_petugas, pembayaran.tahun_ajaran, pembayaran.nominal',
			'siswa',
			'transaksi',
			'siswa.id = transaksi.siswa_id',
			'petugas',
			'petugas.id = transaksi.petugas_id',
			'pembayaran',
			'pembayaran.id = transaksi.pembayaran_id',
			$wheres,
		);

		$result = $this->connection->resultAll($query, array_combine($bindings, $values));

		$this->queried();

		if (!empty($result)) {
			$siswa = $result[0];

			$this->setAttributes([
				'id' => $siswa['id'],
				'nisn' => $siswa['nisn'],
				'nis' => $siswa['nis'],
				'nama' => $siswa['nama'],
				'alamat' => $siswa['alamat'],
				'telepon' => $siswa['telepon'],
			]);

			$transaksi = [];

			if (isset($result[0]['id_transaksi'])) {
				foreach ($result as $data) {
					$transaksi[] = new Transaksi([
						'id' => $data['id_transaksi'],
						'tanggal_dibayar' => $data['tanggal_dibayar'],
						'bulan_dibayar' => $data['bulan_dibayar'],
						'tahun_dibayar' => $data['tahun_dibayar'],
						'petugas' => new Petugas([
							'nama' => $data['nama_petugas']
						]),
						'pembayaran' => new Pembayaran([
							'tahun_ajaran' => $data['tahun_ajaran'],
							'nominal' => $data['nominal'],
						]),
					]);
				}
			}

			$this->setAttribute('transaksi', $transaksi);
		}

		return $this;
	}

	public function getTransaksiHistories()
	{
		$columns = ['transaksi.siswa_id'];
		$values = [$this->id];
		$bindings = QueryHelper::makeColumnBindings($columns);
		$wheres = QueryHelper::makeWheres($bindings);

		$query = sprintf(
			"SELECT %s FROM %s INNER JOIN %s ON %s INNER JOIN %s ON %s INNER JOIN %s ON %s WHERE %s",
			'tanggal_dibayar, bulan_dibayar, tahun_dibayar, tahun_ajaran, petugas.nama', 'siswa', 'transaksi', 'siswa.id = transaksi.siswa_id', 'pembayaran', 'transaksi.pembayaran_id = pembayaran.id', 'petugas', 'transaksi.petugas_id = petugas.id', $wheres
		);

		$result = $this->connection->resultAll($query, array_combine($bindings, $values));

		$transaksi = [];

		if (!empty($result)) {
			foreach ($result as $r) {
				$transaksi[] = new Transaksi([
					'tanggal_dibayar' => $r['tanggal_dibayar'],
					'bulan_dibayar' => $r['bulan_dibayar'],
					'tahun_dibayar' => $r['tahun_dibayar'],
					'pembayaran' => new Pembayaran([
						'tahun_ajaran' => $r['tahun_ajaran'],
					]),
					'petugas' => new Petugas([
						'nama' => $r['nama'],
					])
				]);
			}
		}

		$this->setAttribute('transaksi', $transaksi);

		return $this;
	}
}