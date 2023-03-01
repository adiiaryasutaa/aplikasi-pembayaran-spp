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
		$bindingNames = QueryHelper::makeColumnBindings(['pengguna.role']);
		$wheres = QueryHelper::makeWhereNot($bindingNames);
		$values = [$bindingNames['pengguna.role'] => Role::ADMIN->value];

		$query = sprintf(
			"SELECT %s FROM %s INNER JOIN %s ON %s WHERE %s",
			'petugas.*, username, password, role', $this->table,
			'pengguna',
			"$this->table.pengguna_id = pengguna.id",
			$wheres
		);

		$results = $this->connection->resultAll($query, $values);

		$this->queried();

		$data = [];

		foreach ($results as $result) {
			$pengguna = new Pengguna([
				'id' => $result['pengguna_id'],
				'username' => $result['username'],
				'password' => $result['password'],
				'role' => $result['role']
			]);

			unset($result['pengguna_id'], $result['username'], $result['password'], $result['role']);

			$data[] = array_merge($result, compact('pengguna'));
		}

		return is_array($models = $this->make($data)) ? $models : [$models];
	}

	public function where(array $columns)
	{
		$values = array_values($columns);
		$columns = array_keys($columns);
		$bindings = QueryHelper::makeColumnBindings($columns);
		$wheres = QueryHelper::makeWheres($bindings);

		$query = sprintf(
			"SELECT %s FROM %s WHERE %s",
			'*', $this->table,
			$wheres
		);

		$result = $this->connection->resultAll($query, array_combine($bindings, $values));

		$this->queried();

		return is_array($models = $this->make($result)) ? $models : [$models];
	}

	public function whereFirst(array $columns)
	{
		$values = array_values($columns);
		$columns = array_keys($columns);
		$bindings = QueryHelper::makeColumnBindings($columns);
		$wheres = QueryHelper::makeWheres($bindings);

		$query = sprintf(
			"SELECT %s FROM %s WHERE %s LIMIT 1",
			'*', $this->table,
			$wheres
		);

		$result = $this->connection->result($query, array_combine($bindings, $values));

		$this->queried();

		return $this->make($result);
	}

	public function getDetailWhere(array $columns)
	{
		$values = array_values($columns);
		$columns = array_keys($columns);
		$bindings = QueryHelper::makeColumnBindings($columns);
		$wheres = QueryHelper::makeWheres($bindings);

		$query = sprintf(
			"SELECT %s FROM %s INNER JOIN %s ON %s WHERE %s LIMIT 1",
			'petugas.id AS petugasId, nama, pengguna.id AS penggunaId, username, password, role',
			$this->table,
			'pengguna',
			"pengguna.id = $this->table.pengguna_id",
			$wheres,
		);

		$result = $this->connection->result($query, array_combine($bindings, $values));

		$this->queried();

		$this->setAttributes([
			'id' => $result['petugasId'],
			'nama' => $result['nama'],
			'pengguna' => new Pengguna([
				'id' => $result['penggunaId'],
				'username' => $result['username'],
				'password' => $result['password'],
				'role' => $result['role'],
			]),
		]);

		return $this;
	}

	public function getTotalTransaksi()
	{
		$query = sprintf(
			"SELECT %s FROM %s INNER JOIN %s ON %s WHERE %s",
			"COUNT(*) AS total_transaksi",
			$this->table,
			'transaksi',
			"$this->table.id = transaksi.petugas_id",
			"petugas.id = :id"
		);

		$statement = $this->connection->prepare($query);

		$this->connection->bindValues($statement, ['id' => $this->id]);

		$statement->execute();

		return $statement->fetch()['total_transaksi'];
	}

	public function getByPenggunaId(int $id)
	{
		$pengguna = new Pengguna();
		$penggunaTable = $pengguna->getTable();

		$query = "SELECT * FROM $this->table INNER JOIN $penggunaTable ON $this->table.pengguna_id = $penggunaTable.id WHERE $penggunaTable.id = :penggunaId";

		$statement = $this->connection->prepare($query);

		$this->connection->bindValues($statement, ['penggunaId' => $id]);

		$statement->execute();
		$this->hasBeenQueried = true;

		$result = $statement->fetch();

		$pengguna->setAttributes([
			'id' => $result['pengguna_id'],
			'username' => $result['username'],
			'password' => $result['username'],
			'role' => match ($result['role']) {
				1 => Role::ADMIN,
				2 => Role::PETUGAS,
				3 => Role::SISWA
			},
		]);

		unset($result['pengguna_id'], $result['username'], $result['username'], $result['role']);

		$this->setAttributes(array_merge($result, compact('pengguna')));

		return $this;
	}

	public function insert(array $data)
	{
		$columns = array_keys($data);
		$values = array_values($data);
		$parameters = QueryHelper::makeColumnBindings($columns);

		$query = sprintf(
			"INSERT INTO %s (%s) VALUES (%s)",
			$this->table,
			implode(', ', $columns),
			implode(', ', $parameters),
		);

		return $this->connection->statement($query, array_combine($parameters, $values));
	}

	public function update(array $data)
	{
		$columns = array_keys($data);
		$values = array_merge(array_values($data), [$this->id]);
		$bindings = QueryHelper::makeColumnBindings(array_merge($columns, ['id']));
		$sets = QueryHelper::makeSet(array_diff_key($bindings, ['id' => 'id']));
		$where = QueryHelper::makeWheres(array_intersect_key($bindings, ['id' => 'id']));

		$query = sprintf(
			"UPDATE %s SET %s WHERE %s",
			$this->table,
			$sets,
			$where
		);

		return $this->connection->statement($query, array_combine($bindings, $values));
	}

	public function delete()
	{
		$columns = ['id'];
		$values = [$this->id];
		$where = QueryHelper::makeWheres(QueryHelper::makeColumnBindings($columns));

		$query = sprintf(
			"DELETE FROM %s WHERE %s",
			$this->table,
			$where,
		);

		return $this->connection->statement($query, array_combine($columns, $values));
	}
}