<?php

namespace COre\Foundation\Facade;

use Core\Foundation\Application;

class Session
{
	public static function __callStatic($method, $args)
	{
		return Application::getSession()->{$method}(...$args);
	}
}