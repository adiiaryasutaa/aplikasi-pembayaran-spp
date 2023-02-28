<?php

namespace Core\Database;

use Core\Support\Str;

class QueryHelper
{
	public static function makeColumnBindings(array $columns)
	{
		return array_combine(
			$columns,
			array_map(fn($column) => ':' . Str::camelCase($column, '.'), $columns)
		);
	}

	public static function makeWheres(array $columnWithParameters)
	{
		$columns = array_keys($columnWithParameters);

		return implode(
			' AND ',
			array_map(fn($column) => "$column = {$columnWithParameters[$column]}", $columns)
		);
	}

	public static function makeWhereNot(array $columnWithParameters)
	{
		$columns = array_keys($columnWithParameters);

		return implode(
			' AND ',
			array_map(fn($column) => "$column != {$columnWithParameters[$column]}", $columns)
		);
	}

	public static function makeSet(array $columnWithParameters)
	{
		$columns = array_keys($columnWithParameters);

		return implode(
			', ',
			array_map(fn($column) => "$column = {$columnWithParameters[$column]}", $columns)
		);
	}
}