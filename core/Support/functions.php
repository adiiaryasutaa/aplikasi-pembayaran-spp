<?php

use Core\Foundation\Application;
use Core\Foundation\Facade\Route;
use Core\Routing\Redirector;
use Core\View\View;

function auth()
{
	return Application::getAuth();
}

/**
 * Make a new view instance
 * @param string $name
 * @param array $data
 * @return View
 */
function view(string $name, array $data = [], array $nests = [])
{
	return new View($name, $data, $nests);
}

function request()
{
	return Application::getRequest();
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

function route(string $name, array $parameters = [])
{
	$route = Route::getRouteByName($name);

	if (!is_null($route)) {
		return $route->getFullUri($parameters);
	}

	throw new Exception("Route with name [{$name}] not found");
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

function redirect(string $to, int $status = 302)
{
	return Redirector::to($to, $status);
}

/**
 * Do redirect if condition is true
 * @param bool $condition
 * @param string $to
 * @param int $status
 * @return Core\Http\RedirectResponse|false
 */
function redirectIf(bool $condition, string $to, int $status = 302)
{
	if ($condition) {
		return redirect($to, $status);
	}

	return $condition;
}

/**
 * Do redirect if condition is false
 * @param bool $condition
 * @param string $to
 * @param int $status
 * @return Core\Http\RedirectResponse|bool
 */
function redirectUnless(bool $condition, string $to, int $status = 302)
{
	return redirectIf(!$condition, $to, $status);
}

function back(int $status = 302)
{
	return Redirector::back($status);
}

function session(string $key = null)
{
	$session = Application::getSession();

	if (is_null($key)) {
		return $session;
	}

	return $session->$key;
}

function error(string $key)
{
	return session()->getError($key);
}

function old(string $key, $default = null)
{
	return session()->getInput($key) ?? $default;
}

function dd(...$vars)
{
	echo "<pre>";
	print_r(...$vars);
	echo "</pre>";
	exit();
}