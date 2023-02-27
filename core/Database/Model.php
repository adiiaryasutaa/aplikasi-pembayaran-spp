<?php

namespace Core\Database;

use Core\Extension\Database\HasAttributes;
use Core\Foundation\Application;
use PDO;

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
		$this->attributes = $attributes;
	}

	//public static function all($columns = ['*'])
	//{
	//	$model = new static;
	//	$connection = $model->getDatabaseConnection();

	//	$query = sprintf(
	//		"SELECT %s FROM %s",
	//		implode(', ', is_array($columns) ? $columns : func_get_args()),
	//		$model->getTable(),
	//	);

	//	$statement = $connection->prepare($query);

	//	if (!$statement->execute()) {
	//		return null;
	//	}

	//	$models = [];

	//	foreach ($statement->fetchAll(PDO::FETCH_DEFAULT) as $data) {
	//		$models = new static ($data);
	//	}

	//	return $models;
	//}

	//public static function innerJoin(Model $model, string $on)
	//{

	//}

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