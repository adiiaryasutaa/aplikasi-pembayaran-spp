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

		$parameters = QueryHelper::makeColumnBindings($columns);
		$wheres = QueryHelper::makeWheres($parameters);

		$query = sprintf(
			"SELECT %s FROM %s WHERE %s",
			'*', $this->table,
			$wheres,
		);

		$result = $this->connection->resultAll($query, array_combine($parameters, $value));

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
		$columns = array_keys($data);
		$values = array_values($data);

		$parameters = QueryHelper::makeColumnBindings(array_combine($columns, ['id']));

		$query = sprintf(
			"INSERT INTO %s VALUES (%s)",
			"$this->table (" . implode(',', $columns) . ')',
			implode(', ', array_values($parameters))
		);

		$values['role'] = $values['role'] instanceof Role ? $values['role']->value : $values['role'];

		return $this->connection->statement(
			$query,
			array_combine(array_values($parameters), array_merge($values, [':id' => $this->id]))
		);
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