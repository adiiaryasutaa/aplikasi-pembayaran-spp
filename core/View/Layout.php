<?php

namespace Core\View;

abstract class Layout extends View
{
	/**
	 * The layout view name
	 * @var string
	 */
	protected string $view;

	/**
	 * The string that will replaced by the view
	 * @var string
	 */
	protected string $replace;

	/**
	 * The layout view data
	 * @var array
	 */
	protected array $data = [];

	/**
	 * The layout nested views
	 * @var array
	 */
	protected array $nests = [];

	/**
	 * Layout constructor
	 */
	public function __construct()
	{
		parent::__construct($this->view, $this->data, $this->nests);
	}

	/**
	 * Get replaced string
	 * @return string
	 */
	public function getReplace()
	{
		return $this->replace;
	}
}