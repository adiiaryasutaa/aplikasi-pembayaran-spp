<?php

namespace App\Model;

use Core\Database\Model;
use Core\Support\Str;
use PDO;

class Kelas extends Model
{
	protected string $table = 'kelas';

	public function all()
	{
		$query = "SELECT %s FROM %s LEFT JOIN %s ON %s GROUP BY %s";

		$query = sprintf(
			$query,
			"$this->table.*, COUNT(siswa.id) AS total_siswa",
			$this->table,
			'siswa',
			"$this->table.id = siswa.kelas_id",
			"$this->table.id",
		);

		$statement = $this->connection->prepare($query);

		$statement->execute();

		$models = [];

		foreach ($statement->fetchAll(PDO::FETCH_DEFAULT) as $data) {
			$models[] = new static ($data);
		}

		return $models;
	}

	public function whereFirst(array $columns = [])
	{
		$query = "SELECT %s FROM %s LEFT JOIN %s ON %s WHERE %s LIMIT 1";

		$values = array_values($columns);
		$columns = array_keys($columns);

		$bindingNames = array_combine(
			$columns,
			array_map(fn($column) => ':' . Str::camelCase($column, '.'), $columns)
		);

		$query = sprintf(
			$query,
			"$this->table.*, COUNT(siswa.id) AS total_siswa",
			$this->table,
			'siswa',
			"$this->table.id = siswa.kelas_id",
			implode(' AND ', array_map(fn($column) => "$column = {$bindingNames[$column]}", $columns)),
		);

		$statement = $this->connection->prepare($query);

		$this->connection->bindValues(
			$statement,
			array_combine(array_values($bindingNames), $values)
		);

		if ($statement->execute() && $result = $statement->fetch()) {
			$this->attributes = $result;
		}

		return $this;
	}

	public function insert(string $nama, string $kompetensiKeahlian)
	{
		$query = "INSERT INTO %s VALUES (%s)";

		$query = sprintf(
			$query,
			"$this->table (nama, kompetensi_keahlian)",
			":nama, :kompetensiKeahlian"
		);

		$statement = $this->connection->prepare($query);

		$this->connection->bindValues($statement, compact('nama', 'kompetensiKeahlian'));

		return $statement->execute();
	}

	public function update(array $data)
	{
		$query = "UPDATE %s SET %s WHERE %s";

		$values = array_values($data);
		$columns = array_keys($data);

		$bindingNames = array_combine(
			$columns,
			array_map(fn($column) => ':' . Str::camelCase($column, '.'), $columns),
		);

		$query = sprintf(
			$query,
			$this->table,
			implode(', ', array_map(fn($column) => "$column = {$bindingNames[$column]}", $columns)),
			'id = :id',
		);

		$statement = $this->connection->prepare($query);

		$this->connection->bindValues(
			$statement,
			array_merge(array_combine($columns, $values), ['id' => $this->id])
		);

		return $statement->execute();
	}
}