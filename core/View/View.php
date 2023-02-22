<?php

namespace Core\View;

use Core\Foundation\Application;

class View
{
	/**
	 * The view name
	 * @var string
	 */
	protected string $name;

	/**
	 * The view data
	 * @var array
	 */
	protected array $data = [];

	/**
	 * The nested views
	 * @var View[]
	 */
	protected array $nests = [];

	/**
	 * The view layout
	 * @var Layout|null
	 */
	protected ?Layout $layout = null;

	/**
	 * View constructor
	 * @param string $name
	 * @param array $data
	 * @param array $nests
	 * @param Layout|null $layout
	 */
	public function __construct(string $name, array $data = [], array $nests = [], ?Layout $layout = null)
	{
		$this->name = $name;
		$this->with($data);
		$this->nest($nests);
		$this->layout = $layout;
	}

	/**
	 * Add data
	 * @param array|string $keys
	 * @param mixed $value
	 * @return View
	 */
	public function with(array|string $keys, $value = null)
	{
		if (is_array($keys)) {
			foreach ($keys as $key => $value) {
				$this->with($key, $value);
			}
		} else {
			$this->data[$keys] = $value;
		}

		return $this;
	}

	/**
	 * Add nested views
	 * @param array|string $keys
	 * @param View|null $value
	 * @return View
	 */
	public function nest(array|string $keys, ?View $view = null)
	{
		if (is_array($keys)) {
			foreach ($keys as $key => $view) {
				$this->nest($key, $view instanceof View ? $view : new View($view));
			}
		} else {
			$this->nests[$keys] = $view;
		}

		return $this;
	}

	/**
	 * Use layout for this view
	 * @param Layout $layout
	 * @return View
	 */
	public function useLayout(Layout $layout)
	{
		$this->layout = $layout;

		return $this;
	}

	/**
	 * Render the view
	 * @return array|bool|string
	 */
	public function render()
	{
		ob_start();

		foreach ($this->data as $key => $value) {
			$$key = $value instanceof self ? $value->render() : $value;
		}

		require_once(Application::getViewBasePath() . "/$this->name.view.php");

		$content = ob_get_clean();
		
		foreach ($this->nests as $key => $view) {
			$content = str_replace($key, $view->render(), $content);
		}

		if ($this->usingLayout()) {
			$content = str_replace(
				$this->layout->getReplace(),
				$content,
				$this->layout->render(),
			);
		}

		return $content;
	}

	/**
	 * Check is view using layout
	 * @return bool
	 */
	public function usingLayout()
	{
		return !is_null($this->layout);
	}
}