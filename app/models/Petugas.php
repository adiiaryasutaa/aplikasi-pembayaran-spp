<?php

namespace App\Model;

use Core\Auth\Role;
use Core\Database\Model;
use Core\Database\QueryHelper;

class Petugas extends Model
{
	protected string $table = 'petugas';

	public function all()
	{
		$bindings = QueryHelper::makeColumnBindings(['pengguna.role']);
		$wheres = QueryHelper::makeWheres($bindings);
		$values = [Role::PETUGAS->value];

		$query = sprintf(
			"SELECT %s FROM %s INNER JOIN %s ON %s WHERE %s",
			'petugas.*, username, role', $this->table,
			'pengguna',
			"$this->table.pengguna_id = pengguna.id",
			$wheres
		);

		$results = $this->connection->resultAll($query, array_combine($bindings, $values));

		$this->queried();

		$data = [];

		foreach ($results as $result) {
			$pengguna = new Pengguna([
				'id' => $result['pengguna_id'],
				'username' => $result['username'],
				'role' => $result['role']
			]);

			unset($result['pengguna_id'], $result['username'], $result['role']);

			$data[] = array_merge($result, compact('pengguna'));
		}

		return is_array($models = $this->make($data)) ? $models : [$models];
	}

	public function getDetailWhere(array $columns)
	{
		$values = array_values($columns);
		$columns = array_keys($columns);
		$bindings = QueryHelper::makeColumnBindings($columns);
		$wheres = QueryHelper::makeWheres($bindings);

		$query = sprintf(
			"SELECT %s FROM %s INNER JOIN %s ON %s LEFT JOIN %s ON %s WHERE %s LIMIT 1",
			'petugas.id AS petugasId, nama, pengguna.id AS penggunaId, username, role, COUNT(transaksi.id) AS total_transaksi',
			$this->table,
			'pengguna',
			"pengguna.id = $this->table.pengguna_id",
			'transaksi',
			"transaksi.petugas_id = $this->table.id",
			$wheres,
			"petugas.id",
		);

		$result = $this->connection->result($query, array_combine($bindings, $values));

		$this->queried();

		$this->setAttributes([
			'id' => $result['petugasId'],
			'nama' => $result['nama'],
			'pengguna' => new Pengguna([
				'id' => $result['penggunaId'],
				'username' => $result['username'],
				'role' => $result['role'],
			]),
			'total_transaksi' => $result['total_transaksi'],
		]);

		return $this;
	}

	public function withPenggunaWhereFirst(array $columns)
	{
		$values = array_values($columns);
		$columns = array_keys($columns);
		$bindings = QueryHelper::makeColumnBindings($columns);
		$wheres = QueryHelper::makeWheres($bindings);

		$query = sprintf(
			"SELECT %s FROM %s INNER JOIN %s ON %s WHERE %s",
			'petugas.*, username, role', 'petugas', 'pengguna', 'petugas.pengguna_id = pengguna.id', $wheres
		);

		$result = $this->connection->result($query, array_combine($bindings, $values));

		$this->queried();

		if (!empty($result)) {
			$this->setAttributes([
				'id' => $result['id'],
				'nama' => $result['nama'],
				'pengguna' => new Pengguna([
					'id' => $result['pengguna_id'],
					'username' => $result['username'],
					'role' => $result['role'],
				]),
			]);
		}
		return $this;
	}
}