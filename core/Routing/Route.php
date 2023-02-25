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

	/**
	 * Get route full uri
	 * @return string
	 */
	public function getFullUri()
	{
		return Application::getHost() . $this->uri;
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