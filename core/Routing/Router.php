<?php

namespace Core\Routing;

use Closure;
use Core\Http\Response;
use Core\Routing\Route;

class Router
{
	/**
	 * The list of registered routes
	 * @var array
	 */
	protected array $routes = [];

	/**
	 * Add a new route
	 * @param string $method
	 * @param string $uri
	 * @param array|Closure $action
	 * @return Route
	 */
	public function addRoute(string $method, string $uri, array|Closure $action)
	{
		$this->routes[] = $route = new Route($method, $uri, $action);

		return $route;
	}

	/**
	 * Check route has been registered
	 * @param string $method
	 * @param string $uri
	 * @return bool
	 */
	public function has(string $method, string $uri)
	{
		foreach ($this->routes as $route) {
			if ($route->getMethod() === $method && $route->getUri() === $uri) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get a route
	 * @param string $method
	 * @param string $uri
	 * @return mixed
	 */
	public function getRoute(string $method, string $uri)
	{
		foreach ($this->routes as $route) {
			if ($route->getMethod() === $method && $route->getUri() === $uri) {
				return $route;
			}
		}

		return null;
	}

	/**
	 * Resolve route that being requested
	 * @return Response
	 */
	public function resolve()
	{
		$route = $this->getRoute($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

		if (is_null($route)) {
			return new Response("404 | Not Found", 404);
		}

		$action = $route->getAction();

		if (is_array($action)) {
			$action = [new $action[0] /* Controller class */, $action[1] /* Controller method */];
		}

		$response = call_user_func_array($action, []);

		// If action doesn't return response that not instance of Response class
		// Wrap response into Response class
		if (!$response instanceof Response) {
			$response = new Response($response);
		}

		return $response;
	}
}