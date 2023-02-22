<?php

namespace Core\Foundation\Facade;

use Core\Foundation\Application;

class Auth
{
	public static function __callStatic($method, $args)
	{
		return Application::getAuth()->{$method}(...$args);
	}
}