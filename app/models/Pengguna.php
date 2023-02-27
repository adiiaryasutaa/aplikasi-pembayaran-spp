<?php

namespace App\Model;

use Core\Auth\Role;
use Core\Database\Model;
use PDO;

class Pengguna extends Model
{
	protected string $table = 'pengguna';

	public function __construct(array $attributes = [])
	{
		if (isset($attributes['role']) && !$attributes['role'] instanceof Role) {
			$attributes['role'] = match ($attributes['role']) {
				1 => Role::ADMIN,
				2 => Role::PETUGAS,
				3 => Role::SISWA
			};
		}

		parent::__construct($attributes);
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

		if ($result = $statement->fetch()) {
			$this->attributes = $result;
		}

		return $this;
	}

	public function insert(string $username, string $password, Role $role)
	{
		$query = "INSERT INTO $this->table (username, password, role) VALUES (:username, :password, :role)";

		$statement = $this->connection->prepare($query);

		$this->connection->bindValues(
			$statement,
			array_merge(compact('username', 'password'), ['role' => $role->value])
		);

		return $statement->execute();
	}

	public function isAdmin()
	{
		return $this->role === Role::ADMIN;
	}

	public function isPetugas()
	{
		return $this->role === Role::PETUGAS;
	}

	public function isSiswa()
	{
		return $this->role === Role::SISWA;
	}
}