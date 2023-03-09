<?php

$dirs = [
	'core' => [
		'Database' => [
			'Extension' => [
				'HasAttributes.php',
			],
			'Connection.php',
			'Model.php',
			'QueryHelper.php',
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
			'Rule.php',
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
			'Pembayaran.php',
			'Pengguna.php',
			'Petugas.php',
			'Siswa.php',
			'Transaksi.php',
		],
		'controllers' => [
			'AuthController.php',
			'DashboardController.php',
			'HistoryController.php',
			'KelasController.php',
			'LaporanController.php',
			'PembayaranController.php',
			'PenggunaController.php',
			'PetugasController.php',
			'SiswaController.php',
			'TransaksiController.php',
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

function load(string $basePath, array $dirs)
{
	global $includes;

	foreach ($dirs as $key => $value) {
		if (is_string($key)) {
			load($basePath . '/' . $key, $value);
		} else {
			$includes[] = $basePath . '/' . $value;
		}
	}
}

load(__DIR__, $dirs);

foreach ($includes as $include) {
	include_once($include);
}