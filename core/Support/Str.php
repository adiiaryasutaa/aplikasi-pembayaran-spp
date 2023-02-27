<?php

namespace Core\Support;

class Str
{
	public static function camelCase(string $string, string $separator)
	{
		$a = [];

		foreach (explode($separator, $string) as $i => $b) {
			$a[] = $i === 0 ? $b : ucfirst($b);
		}

		return implode('', $a);
	}
}