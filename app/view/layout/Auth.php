<?php

namespace App\View\Layout;

use Core\View\Layout;

class Auth extends Layout
{
	/**
	 * The layout view name
	 * @var string
	 */
	protected string $view = 'layouts/auth';

	/**
	 * The string that will replaced by the view
	 * @var string
	 */
	protected string $replace = '{$ body $}';

	/**
	 * The layout view data
	 * @var array
	 */
	protected array $data = [
		'title' => 'Login',
	];

	/**
	 * The layout nested views
	 * @var array
	 */
	protected array $nests = [];
}