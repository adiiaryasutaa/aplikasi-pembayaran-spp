<?php

namespace App\Model;

use Core\Database\Model;

class Pengguna extends Model
{
	public function where(string|array $columns, $values = null)
	{
		$query = "SELECT * FROM `pengguna` WHERE ";

		// If columns is array
		// Assume that it's pairs column and value
		if (is_array($columns)) {
			$fields = array_keys($columns);
			$values = array_combine($fields, array_values($columns));

			$query .= implode(' AND ', array_map(fn($field) => "`$field` = :$field", $fields));
		} else {
			$values = ["`petugas`.`$columns`" => $values];
		}

		$this->attributes = $this->database->query($query, $values);
		$this->hasBeenQueried = false;

		return $this;
	}
}