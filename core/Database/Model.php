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
		$this->attributes = $attributes;
	}

	public function exists()
	{
		return $this->hasBeenQueried && !empty($this->attributes);
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