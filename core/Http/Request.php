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
		if ($this->method() === 'POST') {
			$this->session->putInput($_POST);
		}
	}

	/**
	 * Get current request uri
	 * @return mixed
	 */
	public function uri()
	{
		return $_SERVER['REQUEST_URI'];
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
			$inputs[] = $this->$name ?? null;
		}

		return $inputs;
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