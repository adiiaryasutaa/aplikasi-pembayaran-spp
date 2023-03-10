<?php

namespace Core\Validation;

use Core\Foundation\Facade\DB;

class Rule
{
	public static function required()
	{
		return [
			'name' => 'required',
			'error' => '%s dibutuhkan',
			'action' => fn($data) => is_int($data) ? $data > 0 : strlen(trim($data)),
		];
	}

	public static function number()
	{
		return [
			'name' => 'number',
			'error' => '%s harus berupa angka',
			'action' => fn($data) => is_numeric(trim($data)),
		];
	}

	public static function min(int $min)
	{
		return [
			'name' => 'min',
			'error' => "%s minimal memiliki $min karakter",
			'action' => function ($data) use ($min) {
				return strlen($data) >= $min;
			},
		];
	}

	public static function max(int $max)
	{
		return [
			'name' => 'min',
			'error' => "%s maksimal memiliki $max karakter",
			'action' => function ($data) use ($max) {
				return strlen($data) <= $max;
			},
		];
	}

	public static function unique(string $table, string $column, $except = null)
	{
		return [
			'name' => 'unique',
			'error' => "Data ini sudah terdaftar",
			'action' => function ($data) use ($table, $column, $except) {
				$query = sprintf(
					"SELECT %s FROM %s WHERE %s",
					$column,
					$table,
					"$column = :$column",
				);

				$result = DB::result($query, [$column => $data]);

				if (empty($result)) {
					return true;
				}

				return is_null($except) ? false : $result[$column] === $except;
			},
		];
	}

	public static function exists(string $table, string $column)
	{
		return [
			'name' => 'exists',
			'error' => "Data ini belum terdaftar",
			'action' => function ($data) use ($table, $column) {
				$query = sprintf(
					"SELECT %s FROM %s WHERE %s",
					$column,
					$table,
					"$column = :$column",
				);

				$result = DB::result($query, [$column => $data]);

				return !empty($result);
			}
		];
	}

	public static function year()
	{
		return [
			'name' => 'year',
			'error' => "%s harus berupa tahun yang valid",
			'action' => function ($data) {
				if (!is_numeric($data)) {
					return false;
				}

				return $data >= 1 && $data <= 2100;
			}
		];
	}
}