<?php

namespace App\Model;

use Core\Database\Model;
use Core\Database\QueryHelper;

class Kelas extends Model
{
	protected string $table = 'kelas';

	public function all()
	{
		$query = sprintf(
			"SELECT %s FROM %s LEFT JOIN %s ON %s GROUP BY %s",
			"$this->table.*, COUNT(siswa.id) AS total_siswa",
			$this->table,
			'siswa',
			"$this->table.id = siswa.kelas_id",
			"$this->table.id",
		);

		$result = $this->connection->resultAll($query);

		$this->queried();

		return is_array($models = $this->make($result)) ? $models : [$models];
	}

	public function whereFirst(array $columns = [])
	{
		$values = array_values($columns);
		$columns = array_keys($columns);
		$bindingNames = QueryHelper::makeColumnBindings($columns);

		$query = sprintf(
			"SELECT %s FROM %s LEFT JOIN %s ON %s WHERE %s LIMIT 1",
			"$this->table.*, COUNT(siswa.id) AS total_siswa",
			$this->table,
			'siswa',
			"$this->table.id = siswa.kelas_id",
			implode(' AND ', array_map(fn($column) => "$column = {$bindingNames[$column]}", $columns)),
		);

		$result = $this->connection->result($query, array_combine($bindingNames, $values));

		$this->queried();

		$this->setAttributes($result);

		return $this;
	}
}