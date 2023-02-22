<?php

namespace App\Model;

use Core\Database\Model;
use Core\Foundation\Application;

class Siswa extends Model
{
	public function where(string|array $columns, $values = null)
	{
		$query = "SELECT * FROM `petugas` INNER JOIN `pengguna` ON `petugas`.`pengguna_id` = `pengguna`.`id` WHERE ";

		// If columns is array
		// Assume that it's pairs column and value
		if (is_array($columns)) {
			$fields = array_keys($columns);
			$values = array_combine($fields, array_values($columns));

			$query .= implode(' AND ', array_map(fn($field) => "`petugas`.`$field` = :$field", $fields));
		} else {
			$values = ["`petugas`.`$columns`" => $values];
		}

		$this->attributes = $this->database->query($query, $values);

		return $this;
	}
}