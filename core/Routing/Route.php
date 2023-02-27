<?php

namespace Core\Routing;

use Closure;
use Core\Foundation\Application;

class Route
{
	/**
	 * The route method
	 * @var string
	 */
	protected string $method;

	/**
	 * The route uri
	 * @var string
	 */
	protected string $uri;

	/**
	 * The route action
	 * @var array|Closure
	 */
	protected array|Closure $action;

	/**
	 * The route name
	 * @var string|null
	 */
	protected ?string $name;

	/**
	 * Route constructor
	 * @param string $method
	 * @param string $uri
	 * @param array|Closure $action
	 * @param string|null $name
	 */
	public function __construct(string $method, string $uri, array|Closure $action, ?string $name = null)
	{
		$this->method = $method;
		$this->uri = $uri;
		$this->action = $action;
		$this->name = $name;
	}

	public function matches(string $uri)
	{
		return (bool) preg_match_all(
			$this->makeRouteRegex(),
			trim($uri, '/'),
		);
	}

	public function getMatches(string $uri)
	{
		preg_match_all(
			$this->makeRouteRegex(),
			trim($uri, '/'),
			$matches,
		);

		return $matches[1] ?? [];
	}

	/**
	 * Convert route uri into regex pattern
	 * @return string
	 */
	public function makeRouteRegex()
	{
		return "@^" . preg_replace_callback(
			'/\{\w+(:([^}]+))?}/',
			fn($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)',
			trim($this->uri, '/')
		) . "$@";
	}

	public function getParameterNames()
	{
		// \{ -> start with {
		// (\w+) -> have some of alpha symbols
		// (:[^}]+)? -> have semicolon, except } and optional
		// } -> end with }
		preg_match_all('/\{(\w+)(:[^}]+)?}/', trim($this->uri, '/'), $matches);

		return $matches[1] ?? [];
	}

	public function extractArguments(string $uri)
	{
		return array_combine($this->getParameterNames(), $this->getMatches($uri));
	}

	/**
	 * Get route full uri
	 * @return string
	 */
	public function getFullUri(array $parameters = [])
	{
		$path = Application::getHost() . preg_replace_callback(
			'/\{(\w+)(:[^}]+)?}/',
			fn($m) => "{{$m[1]}}",
			$this->uri
		);

		return str_replace(
			array_map(fn($parameter) => "{{$parameter}}", array_keys($parameters)),
			array_values($parameters),
			$path
		);
	}

	/**
	 * Get route method
	 * @return string
	 */
	public function getMethod()
	{
		return $this->method;
	}

	/**
	 * Get route uri
	 * @return string
	 */
	public function getUri()
	{
		return $this->uri;
	}

	/**
	 * Get route action
	 * @return Closure|array
	 */
	public function getAction()
	{
		return $this->action;
	}

	/**
	 * Get route name
	 * @return null|string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set route name
	 * @param string|null $name
	 * @return Route
	 */
	public function setName(?string $name = null)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Check is route has name
	 * @return bool
	 */
	public function hasName()
	{
		return !is_null($this->name);
	}
}