<?php

namespace Core\Routing;

use Core\Http\RedirectResponse;

class Redirector
{
	public static function to(string $to, int $status = 302)
	{
		return new RedirectResponse($to, $status);
	}

	public static function back(int $status = 302)
	{
		return static::to($_SERVER['HTTP_REFERER'], $status);
	}
}