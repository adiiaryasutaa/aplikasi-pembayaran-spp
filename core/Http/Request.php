<?php

namespace Core\Http;

use Core\Session\Store as Session;

class Request
{
	protected Session $session;

	public function __construct(Session $session)
	{
		$this->session = $session;
	}

	public function saveInputsToSession()
	{
		//$this->session->clearInputs();

		if ($this->method() === 'POST') {
			$this->session->putInput($_POST);
		} else {
			$this->session->putInput($this->queries());
		}
	}

	/**
	 * Get current request uri
	 * @return mixed
	 */
	public function uri()
	{
		return explode('?', $_SERVER['REQUEST_URI'])[0];
	}

	/**
	 * Get current request method
	 * @return mixed
	 */
	public function method()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * Get string request input
	 * @param string $name
	 * @return mixed
	 */
	public function string(string $name)
	{
		return (string) ($this->method() == 'GET' ? $_GET[$name] : $_POST[$name]);
	}

	public function only(array $names)
	{
		$inputs = [];

		foreach ($names as $name) {
			$inputs[$name] = $this->string($name) ?? null;
		}

		return $inputs;
	}

	public function queries()
	{
		$query = explode('?', $_SERVER['REQUEST_URI']);

		if (!isset($query[1])) {
			return [];
		}

		$sections = explode('&', $query[1]);

		$names = [];
		$values = [];

		foreach ($sections as $section) {
			[$name, $value] = explode('=', $section);

			$names[] = $name;
			$values[] = $value;
		}

		return array_combine($names, $values);
	}

	public function query(string $name)
	{
		return $this->queries()[$name] ?? null;
	}

	/**
	 * Get string request input
	 * @param string $name
	 * @return string
	 */
	public function __get($name)
	{
		return $this->string($name);
	}
}