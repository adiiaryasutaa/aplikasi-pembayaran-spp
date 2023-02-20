<?php

$dirs = [
	'core' => [
		'Http' => [
			'Request.php',
			'Response.php',
		],
		'Routing' => [
			'Route.php',
			'Router.php',
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
				'Route.php',
			],
			'Application.php',
		]
	],
	'app' => [
		'controllers' => [
			'DashboardController.php',
		],
		'view' => [
			'layout' => [
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