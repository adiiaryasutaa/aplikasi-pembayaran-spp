<?php

namespace Core\Foundation;

use Core\Http\Request;
use Core\Routing\Router;
use Core\Database\Connection as Database;
use Core\Session\Store as Session;
use Core\Auth\AuthManager as Auth;

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
	 * The application database
	 * @var Database
	 */
	protected static Database $database;

	/**
	 * The application session
	 * @var Session
	 */
	protected static Session $session;

	/**
	 * The application auth manager
	 * @var Auth
	 */
	protected static Auth $auth;

	/**
	 * The application request
	 * @var Request
	 */
	protected static Request $request;

	/**
	 * Application constructor
	 * @param array $configs
	 */
	public function __construct(array $configs = [])
	{
		$this->readConfigs($configs);

		$this->init();

		$this->registerRoutes();
	}

	/**
	 * Initialize application components (Router, Database, Session, etc...)
	 * @return void
	 */
	private function init()
	{
		self::$router = new Router();

		self::$database = new Database(
			true,
			require_once(self::$basePath . '/app/config/database.php')
		);

		self::$session = new Session();

		self::$auth = new Auth();

		self::$request = new Request();
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

	/**
	 * Get application database
	 * @return Database
	 */
	public static function getDatabase()
	{
		return self::$database;
	}

	/**
	 * Get application session
	 * @return Session
	 */
	public static function getSession()
	{
		return self::$session;
	}

	/**
	 * Get application auth manager
	 * @return Auth
	 */
	public static function getAuth()
	{
		return self::$auth;
	}

	/**
	 * Get application request
	 * @return Request
	 */
	public static function getRequest()
	{
		return self::$request;
	}
}