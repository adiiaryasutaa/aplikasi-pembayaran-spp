<?php

namespace Core\Session;

class Store
{
	protected array $attributes = [];

	protected bool $started = false;

	public function __construct()
	{
		$this->start();

		$this->attributes = & $_SESSION;
	}

	public function start()
	{
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
			$this->started = true;
		}

		return $this;
	}

	public function put(string|array $keys, $value = null)
	{
		if (is_array($keys)) {
			foreach ($keys as $key => $value) {
				$this->put($key, $value);
			}
		} else {
			$this->attributes[$keys] = $value;
		}

		return $this;
	}

	public function get(string $key, $default = null)
	{
		return $this->has($key) ? $this->attributes[$key] : $default;
	}

	public function pull(string $key, $default = null)
	{
		$value = $this->get($key, $default);
		$this->remove($key);

		return $value;
	}

	public function remove(string $key)
	{
		if ($this->has($key)) {
			unset($this->attributes[$key]);
		}

		return $this;
	}

	public function has(string $key)
	{
		return isset($this->attributes[$key]);
	}

	public function __get($name)
	{
		return $this->get($name);
	}
}