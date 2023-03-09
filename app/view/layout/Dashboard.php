<?php

namespace App\View\Layout;

use Core\View\Layout;

class Dashboard extends Layout
{
	/**
	 * The layout view name
	 * @var string
	 */
	protected string $view = 'layouts/dashboard';

	/**
	 * The string that will replaced by the view
	 * @var string
	 */
	protected string $replace = '{$ body $}';

	/**
	 * The layout view data
	 * @var array
	 */
	protected array $data = [];

	/**
	 * The layout nested views
	 * @var array
	 */
	protected array $nests = [
		'{$ sidebar $}' => 'partials/sidebar',
		'{$ topbar $}' => 'partials/topbar',
		'{$ footer $}' => 'partials/footer',
		'{$ logout-modal $}' => 'partials/logout-modal',
		'{$ sttb $}' => 'partials/scroll-to-top-button',
	];

	public function __construct(string $title = '')
	{
		$this->data['title'] = $title;

		parent::__construct();
	}
}