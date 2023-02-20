<?php

namespace Core\Foundation;

use Core\Routing\Router;

class Application
{
	/**
	 * The application host
	 * @var string
	 */
	protected static string $host;

	/**
	 * The application base path
	 * @var string
	 */
	protected static string $basePath;

	/**
	 * The application route path
	 * @var string
	 */
	protected static string $routePath;

	/**
	 * The application view base path
	 * @var string
	 */
	protected static string $viewBasePath;

	/**
	 * The application Router
	 * @var Router
	 */
	protected static Router $router;

	/**
	 * Application constructor
	 * @param array $configs
	 */
	public function __construct(array $configs = [])
	{
		$this->readConfigs($configs);

		self::$router = new Router();

		$this->registerRoutes();
	}

	/**
	 * Read configs that given from application constructor
	 * @param array $config
	 * @return void
	 */
	protected function readConfigs(array $config)
	{
		self::$host = $config['host'];
		self::$basePath = $config['base_path'];
		self::$routePath = $config['route_path'];
		self::$viewBasePath = $config['view_base_path'];
	}

	/**
	 * Start application
	 * @return void
	 */
	public function start()
	{
		$response = self::$router->resolve();

		$response->send();
	}

	/**
	 * Register routes from the route path
	 * @return void
	 */
	protected function registerRoutes()
	{
		require_once(self::$routePath);
	}

	/**
	 * Get application host
	 * @return string
	 */
	public static function getHost()
	{
		return self::$host;
	}

	/**
	 * Get application base path
	 * @return string
	 */
	public static function getBasePath()
	{
		return self::$basePath;
	}

	/**
	 * Get application route path
	 * @return string
	 */
	public static function getRoutePath()
	{
		return self::$routePath;
	}

	/**
	 * Get application view base path 
	 * @return string
	 */
	public static function getViewBasePath()
	{
		return self::$viewBasePath;
	}

	/**
	 * Get application router
	 * @return Router
	 */
	public static function getRouter()
	{
		return self::$router;
	}
}