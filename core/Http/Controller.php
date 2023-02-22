<?php

namespace Core\Http;

use Core\Foundation\Application;

abstract class Controller
{
	protected function request(string $name = null)
	{
		$request = Application::getRequest();

		if (is_null($name)) {
			return $request;
		}

		return $request->$name;
	}
}