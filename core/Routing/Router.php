<?php

namespace Core\Routing;

use Closure;
use Core\Http\Request;
use Core\Http\Response;
use Core\Routing\Route;

class Router
{
	/**
	 * The list of registered routes
	 * @var array
	 */
	protected array $routes = [];

	protected Request $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

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
		$routes = $this->getRouteMap($method);

		foreach ($routes as $route) {
			if ($route->matches($uri)) {
				return $route;
			}
		}

		return null;
	}

	public function getRouteMap(string $method)
	{
		$routes = [];

		foreach ($this->routes as $route) {
			if ($route->getMethod() === $method) {
				$routes[] = $route;
			}
		}

		return $routes;
	}

	public function getRouteByName(string $name)
	{
		foreach ($this->routes as $route) {
			if ($route->getName() === $name) {
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
		$this->parseQueryString();

		$method = request()->method();
		$uri = request()->uri();

		$route = $this->getRoute($method, $uri);

		if (is_null($route)) {
			return notFound();
		}

		$action = $route->getAction();

		if (is_array($action)) {
			$action = [new $action[0] /* Controller class */, $action[1] /* Controller method */];
		}

		$response = call_user_func_array($action, $route->extractArguments($uri));

		// If action doesn't return response that not instance of Response class
		// Wrap response into Response class
		if (!$response instanceof Response) {
			$response = new Response($response);
		}

		return $response;
	}

	protected function parseQueryString()
	{
		$query = $_SERVER['QUERY_STRING'];
	}
}