<?php

namespace Core\Foundation\Facade;

use Closure;
use Core\Foundation\Application;

class Route
{
	/**
	 * Add route with GET method
	 * @param string $uri
	 * @param array|Closure $action
	 * @return \Core\Routing\Route
	 */
	public static function get(string $uri, array|Closure $action)
	{
		return Application::getRouter()->addRoute('GET', $uri, $action);
	}

	/**
	 * Add route with POST method
	 * @param string $uri
	 * @param array|Closure $action
	 * @return \Core\Routing\Route
	 */
	public static function post(string $uri, array|Closure $action)
	{
		return Application::getRouter()->addRoute('POST', $uri, $action);
	}
}