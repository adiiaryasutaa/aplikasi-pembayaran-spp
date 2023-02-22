<?php

namespace Core\Http;

class Request
{
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