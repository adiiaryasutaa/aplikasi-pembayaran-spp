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

	public function insert(array $data)
	{
		$columns = array_keys($data);
		$values = array_values($data);
		$bindingNames = QueryHelper::makeColumnBindings($columns);

		$query = sprintf(
			"INSERT INTO %s (%s) VALUES (%s)",
			"$this->table",
			implode(', ', $columns),
			implode(',', $bindingNames),
		);

		return $this->connection->statement($query, array_combine($bindingNames, $values));
	}

	public function update(array $data)
	{
		$columns = array_keys($data);
		$values = array_merge(array_values($data), [$this->id]);
		$bindingNames = QueryHelper::makeColumnBindings(array_merge($columns, ['id']));
		$sets = QueryHelper::makeSet(array_diff_key($bindingNames, ['id' => 'id']));
		$wheres = QueryHelper::makeWheres(array_intersect_key($bindingNames, ['id' => 'id']));

		$query = sprintf(
			"UPDATE %s SET %s WHERE %s",
			$this->table,
			$sets,
			$wheres,
		);

		return $this->connection->statement($query, array_combine($bindingNames, $values));
	}

	public function delete()
	{
		$bindingNames = QueryHelper::makeColumnBindings(['id']);
		$where = QueryHelper::makeWheres($bindingNames);

		$query = sprintf(
			"DELETE FROM %s WHERE %s",
			$this->table,
			$where
		);

		$bool = $this->connection->statement($query, array_combine($bindingNames, [$this->id]));

		if ($bool) {
			$this->resetAttributes();
		}

		return $bool;
	}
}