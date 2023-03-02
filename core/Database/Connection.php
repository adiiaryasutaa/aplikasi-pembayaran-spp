<?php

namespace Core\Database;

use PDO;
use PDOStatement;

class Connection
{
	protected PDO $pdo;

	protected string $database;

	protected int $pdoFetchMode = PDO::FETCH_ASSOC;

	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;

		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function prepare(string $query, array|null $options = [])
	{
		$statement = $this->pdo->prepare(...func_get_args());

		$statement->setFetchMode($this->pdoFetchMode);

		return $statement;
	}

	public function bindValues(PDOStatement $statement, array $bindings)
	{
		foreach ($bindings as $key => $value) {
			$statement->bindValue(
				$key,
				$value,
				match (true) {
					is_int($value) => PDO::PARAM_INT,
					default => PDO::PARAM_STR
				}
			);
		}
	}

	public function statement(string $query, array $bindings = [])
	{
		$statement = $this->prepare($query);

		$this->bindValues($statement, $bindings);

		return $statement->execute();
	}

	public function result(string $query, array $bindings = [])
	{
		$statement = $this->prepare($query);

		$this->bindValues($statement, $bindings);

		$statement->execute();

		return ($result = $statement->fetch()) ? $result : [];
	}

	public function resultAll(string $query, array $bindings = [])
	{
		$statement = $this->prepare($query);

		$this->bindValues($statement, $bindings);

		$statement->execute();

		return $statement->fetchAll(PDO::FETCH_DEFAULT);
	}

	public function __call($method, $args)
	{
		return $this->pdo->{$method}(...$args);
	}
}