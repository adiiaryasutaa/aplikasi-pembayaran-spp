<?php

$dirs = [
	'core' => [
		'Database' => [
			'Extension' => [
				'HasAttributes.php',
			],
			'Connection.php',
			'Model.php',
		],
		'Http' => [
			'Controller.php',
			'Request.php',
			'Response.php',
			'RedirectResponse.php',
		],
		'Routing' => [
			'Route.php',
			'Router.php',
			'Redirector.php',
		],
		'Session' => [
			'Store.php',
		],
		'Auth' => [
			'AuthManager.php',
			'Role.php',
		],
		'Support' => [
			'functions.php',
			'Str.php',
		],
		'Validation' => [
			'Rules.php',
			'Validator.php',
		],
		'View' => [
			'View.php',
			'Layout.php',
		],
		'Foundation' => [
			'Facade' => [
				'Auth.php',
				'DB.php',
				'Session.php',
				'Route.php',
			],
			'Application.php',
		]
	],
	'app' => [
		'models' => [
			'Kelas.php',
			'Pengguna.php',
			'Petugas.php',
			'Siswa.php',
		],
		'controllers' => [
			'AuthController.php',
			'DashboardController.php',
			'KelasController.php',
			'PetugasController.php',
			'SiswaController.php',
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