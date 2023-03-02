<?php

namespace App\Model;

use Core\Database\Model;
use Core\Database\QueryHelper;

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
		$bindings = QueryHelper::makeColumnBindings($columns);
		$wheres = QueryHelper::makeWheres($bindings);

		$query = sprintf(
			"SELECT %s FROM %s LEFT JOIN %s ON %s LEFT JOIN %s ON %s WHERE %s LIMIT 1",
			"$this->table.*, COUNT(siswa.id) AS total_siswa, COUNT(transaksi.id) AS total_transaksi",
			$this->table,
			'siswa',
			"$this->table.id = siswa.pembayaran_id",
			'transaksi',
			"$this->table.id = transaksi.pembayaran_id",
			$wheres
		);

		$data = $this->connection->result($query, array_combine($bindings, $values));

		$this->queried();

		$this->setAttributes($data);

		return $this;
	}
}