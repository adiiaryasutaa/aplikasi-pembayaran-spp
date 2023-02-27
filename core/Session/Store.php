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

	public function remove(string $key)
	{
		if ($this->has($key)) {
			unset($this->attributes[$key]);
		}

		return $this;
	}

	public function pull(string $key, $default = null)
	{
		$value = $this->get($key, $default);
		$this->remove($key);

		return $value;
	}

	public function has(string $key)
	{
		return isset($this->attributes[$key]);
	}

	public function setFlash(string|array $keys, $value = null)
	{
		if (is_array($keys)) {
			$keys = array_combine(
				array_map(fn($key) => "_flash.$key", array_keys($keys)),
				array_values($keys)
			);
		} else {
			$keys = "_flash.$keys";
		}

		$this->put($keys, $value);
	}

	public function getFlash(string $key)
	{
		return $this->pull("_flash.$key");
	}

	public function hasFlash(string $key)
	{
		return $this->has("_flash.$key");
	}

	public function putError(string|array $keys, $value = null)
	{
		if (is_array($keys)) {
			$keys = array_combine(
				array_map(fn($key) => "_error.$key", array_keys($keys)),
				array_values($keys)
			);
		} else {
			$keys = "_error.$keys";
		}

		$this->put($keys, $value);
	}

	public function getError(string $key)
	{
		return $this->pull("_error.$key");
	}

	public function hasError(string $key)
	{
		return $this->has("_error.$key");
	}

	public function putInput(string|array $keys, $value = null)
	{
		if (is_array($keys)) {
			$keys = array_combine(
				array_map(fn($key) => "_old.$key", array_keys($keys)),
				array_values($keys)
			);
		} else {
			$keys = "_old.$keys";
		}

		$this->put($keys, $value);
	}

	public function getInput(string $key)
	{
		return $this->pull("_old.$key");
	}

	public function hasInput(string $key)
	{
		return $this->has("_input.$key");
	}

	public function __get($name)
	{
		return $this->get($name) ?? $this->getFlash($name);
	}
}