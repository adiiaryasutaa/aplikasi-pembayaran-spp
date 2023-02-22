<?php

namespace Core\Database;

use PDO;
use PDOException;

class Connection
{
	/**
	 * The active PDO connection
	 * @var PDO
	 */
	protected PDO $pdo;

	/**
	 * The database host
	 * @var string
	 */
	protected string $host;

	/**
	 * The database port
	 * @var string
	 */
	protected string $port;

	/**
	 * The database name
	 * @var string
	 */
	protected string $database;

	/**
	 * The database user
	 * @var string
	 */
	protected string $user;

	/**
	 * The database password
	 * @var string
	 */
	protected string $password;

	/**
	 * Connection constructor
	 * @param array $config
	 */
	public function __construct(bool $autoConnect = true, array $configs = [])
	{
		$this->database = $configs['database'];
		$this->host = $configs['host'];
		$this->port = $configs['port'];
		$this->user = $configs['user'];
		$this->password = $configs['password'];

		if ($autoConnect) {
			$this->connect();
		}
	}

	/**
	 * Connect to database
	 * @return void
	 */
	public function connect()
	{
		try {
			$this->pdo = new PDO("mysql:host=$this->host:$this->port;dbname=$this->database", $this->user, $this->password);

			$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit();
		}
	}

	public function query(string $query, array $params = [], int $fetchMode = PDO::FETCH_ASSOC)
	{
		$preparedStatement = $this->pdo->prepare($query);

		//foreach ($params as $key => $value) {
		//	$preparedStatement->bindParam($key, $value);
		//}

		$preparedStatement->execute($params);

		return $preparedStatement->fetch();
	}
}