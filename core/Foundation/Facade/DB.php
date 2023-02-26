<?php

namespace Core\Foundation\Facade;

use Core\Foundation\Application;

class DB
{
	public static function __callStatic($method, $args)
	{
		return Application::getDatabaseConnection()->{$method}(...$args);
	}
}