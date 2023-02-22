<?php

namespace Core\Database;

use Core\Database\Connection as Database;
use Core\Database\Extension\HasAttributes;
use Core\Foundation\Application;

abstract class Model
{
	use HasAttributes;

	protected Database $database;

	protected bool $hasBeenQueried = false;

	public function __construct()
	{
		$this->database = Application::getDatabase();
	}

	public function exists()
	{
		if ($this->hasBeenQueried) {
			return false;
		}

		return !empty($this->attributes);
	}

	public function __get($name)
	{
		return $this->getAttributes($name);
	}
}