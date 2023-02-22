<?php

use Core\Foundation\Application;
use Core\Foundation\Facade\Route;
use Core\View\View;

/**
 * Make a new view instance
 * @param string $name
 * @param array $data
 * @return View
 */
function view(string $name, array $data = [])
{
	return new View($name, $data);
}

/**
 * Get public asset
 * @param mixed $path
 * @return string
 */
function asset($path)
{
	return Application::getHost() . "/$path";
}

function routeIs(string $name)
{
	$currentRoute = $_SERVER['REQUEST_URI'];
	$route = Route::getRouteByName($name);

	if (is_null($route)) {
		return false;
	}

	return $route->getUri() === $currentRoute;
}

function route(string $path)
{
	$route = Route::getRouteByName($path);

	if (!is_null($route)) {
		$path = $route->getUri();
	}

	return Application::getHost() . (!str_starts_with($path, '/') ? '/' : '') . $path;
}

function dd(...$vars)
{
	echo "<pre>";
	var_dump(...$vars);
	echo "</pre>";
	exit();
}