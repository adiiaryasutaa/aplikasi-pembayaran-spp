<?php

$dirs = [
	'core' => [
		'Database' => [
			'Extensions' => [
				'HasAttributes.php',
			],
			'Model.php',
			'Connection.php',
		],
		'Http' => [
			'Controller.php',
			'Request.php',
			'Response.php',
		],
		'Routing' => [
			'Route.php',
			'Router.php',
		],
		'Session' => [
			'Store.php',
		],
		'Auth' => [
			'AuthManager.php',
		],
		'Support' => [
			'functions.php',
		],
		'View' => [
			'View.php',
			'Layout.php',
		],
		'Foundation' => [
			'Facade' => [
				'Auth.php',
				'Session.php',
				'Route.php',
			],
			'Application.php',
		]
	],
	'app' => [
		'models' => [
			'Pengguna.php',
			'Petugas.php',
		],
		'controllers' => [
			'LoginController.php',
			'DashboardController.php',
			'PetugasController.php',
		],
		'view' => [
			'layout' => [
				'Auth.php',
				'Dashboard.php',
			]
		]
	]
];

$includes = [];

function b(string $basePath, array $dirs)
{
	global $includes;

	foreach ($dirs as $key => $value) {
		if (is_string($key)) {
			b($basePath . '/' . $key, $value);
		} else {
			$includes[] = $basePath . '/' . $value;
		}
	}
}

b(__DIR__, $dirs);

foreach ($includes as $include) {
	include_once($include);
}