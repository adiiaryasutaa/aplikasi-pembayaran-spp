<?php

namespace App\Model;

use Core\Database\Model;
use Core\Database\QueryHelper;
use Core\Support\Str;

class Pembayaran extends Model
{
	protected string $table = 'pembayaran';

	public function all()
	{
		$query = sprintf(
			"SELECT %s FROM %s",
			'*', $this->table
		);

		$result = $this->connection->resultAll($query);

		return $this->make($result);
	}

	public function getDetailWhereFirst(array $columns)
	{
		$values = array_values($columns);
		$columns = array_keys($columns);
		$bindingNames = array_combine(
			$columns,
			array_map(fn($column) => ':' . Str::camelCase($column, '.'), $columns)
		);

		$query = sprintf(
			"SELECT %s FROM %s INNER JOIN %s ON %s INNER JOIN %s ON %s WHERE %s LIMIT 1",
			"$this->table.*, COUNT(siswa.id) AS total_siswa, COUNT(transaksi.id) AS total_transaksi",
			$this->table,
			'siswa',
			"$this->table.id = siswa.pembayaran_id",
			'transaksi',
			"$this->table.id = transaksi.pembayaran_id",
			implode(array_map(fn($column) => "$column = {$bindingNames[$column]}", $columns))
		);

		$data = $this->connection->result($query, array_combine($bindingNames, $values));
		$this->queried();

		$this->setAttributes($data);

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
			implode(', ', $bindingNames)
		);

		return $this->connection->statement(
			$query,
			array_combine($bindingNames, $values)
		);
	}

	public function update(array $data)
	{
		$columns = array_keys($data);
		$values = array_merge(array_values($data), [$this->id]);
		$bindingNames = QueryHelper::makeColumnBindings($columns);
		$sets = QueryHelper::makeSet($bindingNames);
		$wheres = QueryHelper::makeWheres(QueryHelper::makeColumnBindings(['id']));

		$query = sprintf(
			"UPDATE %s SET %s WHERE %s",
			$this->table,
			$sets,
			$wheres
		);

		return $this->connection->statement($query, array_combine(array_merge($bindingNames, [':id']), $values));
	}

	public function delete()
	{
		$values = [$this->id];
		$bindings = QueryHelper::makeColumnBindings(['id']);
		$wheres = QueryHelper::makeWheres($bindings);

		$query = sprintf(
			"DELETE FROM %s WHERE %s",
			$this->table,
			$wheres
		);

		return $this->connection->statement($query, array_combine($bindings, $values));
	}
}