<?php

namespace App\Model;

use Core\Database\Model;
use Core\Database\QueryHelper;

class Transaksi extends Model
{
	protected string $table = 'transaksi';

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
}