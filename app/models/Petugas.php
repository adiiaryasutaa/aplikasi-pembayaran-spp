<?php

namespace App\Model;

use Core\Auth\Role;
use Core\Database\Model;
use Core\Database\QueryHelper;
use Core\Foundation\Facade\DB;
use Core\Support\Str;
use Exception;
use PDO;

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

	public function where(string|array $columns, $value = null)
	{
		$query = "SELECT * FROM $this->table WHERE ";

		if (is_array($columns)) {
			$value = array_values($columns);
			$columns = array_keys($columns);

			$query .= implode(' AND ', array_map(fn($column) => "$column = :$column", $columns));
		} else {
			$query .= "$columns = :$columns";
		}

		$statement = $this->connection->prepare($query);

		$this->connection->bindValues(
			$statement,
			is_array($columns) ? array_combine($columns, $value) : [$columns => $value]
		);

		$statement->execute();
		$this->hasBeenQueried = true;

		$models = [];
		foreach ($statement->fetchAll(PDO::FETCH_DEFAULT) as $attributes) {
			$models[] = new static ($attributes);
		}

		return $models;
	}

	public function whereFirst(string|array $columns, $value = null)
	{
		$query = "SELECT * FROM $this->table WHERE ";

		if (is_array($columns)) {
			$value = array_values($columns);
			$columns = array_keys($columns);

			$query .= implode(' AND ', array_map(fn($column) => "$column = :$column", $columns));
		} else {
			$query .= "$columns = :$columns";
		}

		$query .= " LIMIT 1";

		$statement = $this->connection->prepare($query);

		$this->connection->bindValues(
			$statement,
			is_array($columns) ? array_combine($columns, $value) : [$columns => $value]
		);

		$statement->execute();
		$this->hasBeenQueried = true;

		$this->attributes = $statement->fetch();

		return $this;
	}

	public function joinWithPetugasWhereFirst(string|array $columns, $value = null)
	{
		$penggunaTable = (new Pengguna)->getTable();

		$query = "SELECT %s FROM %s INNER JOIN %s ON %s WHERE %s";

		$wheres = [];
		$bindingNames = [];
		$value = array_values($columns);

		if (is_array($columns)) {
			$columns = array_keys($columns);

			foreach ($columns as $column) {
				$bindingNames[$column] = Str::camelCase($column, '.');
			}
		} else {
			$bindingNames[$columns] = Str::camelCase($columns, '.');
		}

		foreach ($columns as $i => $column) {
			$wheres[] = "$column = :{$bindingNames[$column]}";
		}

		$query = sprintf(
			$query,
			'petugas.id AS petugasId, nama, pengguna.id AS penggunaId, username, password, role',
			$this->table,
			$penggunaTable,
			"$penggunaTable.id = $this->table.pengguna_id",
			implode(' AND ', $wheres),
		);

		$statement = $this->connection->prepare($query);

		$this->connection->bindValues(
			$statement,
			array_combine(array_values($bindingNames), $value),
		);

		if ($statement->execute()) {
			$result = $statement->fetch();

			$this->attributes = $result ? [
				'id' => $result['petugasId'],
				'nama' => $result['nama'],
				'pengguna' => new Pengguna([
					'id' => $result['penggunaId'],
					'username' => $result['username'],
					'password' => $result['password'],
					'role' => $result['role'],
				]),
			] : [];
		}

		$this->hasBeenQueried = true;

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

	public function insert(string $nama, int $penggunaId)
	{
		$query = "INSERT INTO $this->table (nama, pengguna_id) VALUES (:nama, :penggunaId)";

		$statement = $this->connection->prepare($query);

		$this->connection->bindValues($statement, compact('nama', 'penggunaId'));

		return $statement->execute();
	}

	public function update(array $data = [])
	{
		$query = "UPDATE %s INNER JOIN %s ON %s SET %s WHERE %s";

		$values = array_values($data);
		$columns = array_keys($data);

		$bindingNames = [];

		foreach ($columns as $column) {
			$bindingNames[$column] = ':' . Str::camelCase($column, '.');
		}

		$query = sprintf(
			$query,
			$this->table,
			'pengguna',
			"$this->table.pengguna_id = pengguna.id",
			implode(', ', array_map(fn($column) => "$column = {$bindingNames[$column]}", $columns)),
			"$this->table.id = :id"
		);

		$statement = $this->connection->prepare($query);

		$this->connection->bindValues(
			$statement,
			array_merge(array_combine($columns, $values), ['id' => $this->id])
		);

		return $statement->execute();
	}

	public function deleteWhere(array $columns = [])
	{
		$query = "DELETE %s, %s FROM %s INNER JOIN %s ON %s WHERE %s";

		$values = array_values($columns);
		$columns = array_keys($columns);

		$query = sprintf(
			$query,
			$this->table,
			'pengguna',
			$this->table,
			'pengguna',
			"$this->table.pengguna_id = pengguna.id",
			implode(' AND ', array_map(fn($column) => "$column = :$column", $columns)),
		);

		try {
			DB::beginTransaction();

			$statement = $this->connection->prepare($query);

			$this->connection->bindValues($statement, array_combine($columns, $values));

			if (!$statement->execute()) {
				throw new Exception();
			}

			DB::commit();

			return true;
		} catch (Exception $ex) {
			DB::rollback();
			dd($ex->getMessage());

			return false;
		}

	}
}