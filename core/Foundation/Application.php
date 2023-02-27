<?php

namespace Core\Foundation;

use Core\Http\Request;
use Core\Routing\Router;
use Core\Database\Connection as DatabaseConnection;
use Core\Session\Store as Session;
use Core\Auth\AuthManager as Auth;
use PDO;

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
	 * @var DatabaseConnection
	 */
	protected static DatabaseConnection $databaseConnection;

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
		self::$session = new Session();
		self::$request = new Request(self::$session);
		self::$router = new Router(self::$request);

		$databaseConfig = require_once(self::$basePath . '/app/config/database.php');

		self::$databaseConnection = new DatabaseConnection(
			new PDO(
				sprintf('mysql:host=%s;port=%s;dbname=%s', $databaseConfig['host'], $databaseConfig['port'], $databaseConfig['database']),
				$databaseConfig['user'],
				$databaseConfig['password'],
			)
		);
		self::$auth = new Auth();
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
		self::$request->saveInputsToSession();

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
	 * Get application database connection
	 * @return DatabaseConnection
	 */
	public static function getDatabaseConnection()
	{
		return self::$databaseConnection;
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