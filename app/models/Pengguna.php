<?php

namespace App\Model;

use Core\Auth\Role;
use Core\Database\Model;
use Core\Database\QueryHelper;

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

	public function where(array $columns): array
	{
		$value = array_values($columns);
		$columns = array_keys($columns);

		$bindings = QueryHelper::makeColumnBindings($columns);
		$wheres = QueryHelper::makeWheres($bindings);

		$query = sprintf(
			"SELECT %s FROM %s WHERE %s",
			'*', $this->table,
			$wheres,
		);

		$result = $this->connection->resultAll($query, array_combine($bindings, $value));

		$this->queried();

		return is_array($models = $this->make($result)) ? $models : [$models];
	}

	public function whereFirst(array $columns)
	{
		$value = array_values($columns);
		$columns = array_keys($columns);

		$parameters = QueryHelper::makeColumnBindings($columns);
		$wheres = QueryHelper::makeWheres($parameters);

		$query = sprintf(
			"SELECT %s FROM %s WHERE %s LIMIT 1",
			'*', $this->table,
			$wheres,
		);

		$result = $this->connection->result($query, array_combine($parameters, $value));

		$this->queried();

		$this->setAttributes($result);

		return $this;
	}

	public function insert(array $data)
	{
		$data['role'] = $data['role'] instanceof Role ? $data['role']->value : $data['role'];

		$columns = array_keys($data);
		$values = array_values($data);
		$parameters = QueryHelper::makeColumnBindings(array_merge($columns));

		$query = sprintf(
			"INSERT INTO %s (%s) VALUES (%s)",
			"$this->table",
			implode(', ', $columns),
			implode(', ', $parameters),
		);

		return $this->connection->statement(
			$query,
			array_combine($parameters, $values)
		);
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
			"DELETE %s WHERE %s",
			$this->table,
			$where,
		);

		return $this->connection->statement($query, array_combine($columns, $values));
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