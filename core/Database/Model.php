<?php

namespace Core\Database;

use Core\Extension\Database\HasAttributes;
use Core\Foundation\Application;

abstract class Model
{
	use HasAttributes;

	protected Connection $connection;

	protected string $table;

	protected string $primaryKey = 'id';

	protected bool $hasBeenQueried = false;

	public function __construct(array $attributes = [])
	{
		$this->connection = Application::getDatabaseConnection();
		$this->setAttributes($attributes);
	}

	public function all()
	{
		$query = sprintf(
			"SELECT %s FROM %s",
			'*', $this->table
		);

		$result = $this->connection->resultAll($query);

		return $this->make($result);
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
			implode(', ', $bindingNames)
		);

		return $this->connection->statement(
			$query,
			array_combine($bindingNames, $values)
		);
	}

	public function update(array $data)
	{
		$columns = array_merge(array_keys($data), ['id']);
		$values = array_merge(array_values($data), [$this->id]);

		$bindings = QueryHelper::makeColumnBindings($columns);
		$sets = QueryHelper::makeSet(array_diff_key($bindings, ['id' => 1]));
		$wheres = QueryHelper::makeWheres(array_intersect_key($bindings, ['id' => 1]));

		$query = sprintf(
			"UPDATE %s SET %s WHERE %s",
			$this->table,
			$sets,
			$wheres
		);

		return $this->connection->statement($query, array_combine($bindings, $values));
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

	public static function make(array $attributes = [])
	{
		if (empty($attributes)) {
			return [];
		}

		if (!is_array(reset($attributes))) {
			return new static($attributes);
		}

		$models = [];

		foreach ($attributes as $attr) {
			$models[] = new static($attr);
		}

		return $models;
	}

	public function queried()
	{
		$this->hasBeenQueried = true;
	}

	public function exists()
	{
		return $this->hasBeenQueried && !empty($this->attributes);
	}

	public function getDatabaseConnection()
	{
		return $this->connection;
	}

	public function getTable()
	{
		return $this->table;
	}

	public function getPrimaryKeyColumnName()
	{
		return $this->primaryKey;
	}

	public static function __callStatic($method, $args)
	{
		return (new static )->{$method}(...$args);
	}

	public function __get($name)
	{
		return $this->getAttribute($name);
	}

	public function __set($name, $value)
	{
		return $this->setAttribute($name, $value);
	}
}