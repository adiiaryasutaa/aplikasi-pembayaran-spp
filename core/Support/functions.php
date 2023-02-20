<?php

use Core\Foundation\Application;
use Core\View\View;

/**
 * Make a new view instance
 * @param string $name
 * @param array $data
 * @return View
 */
function view(string $name, array $data = [])
{
	return new View($name, $data);
}

/**
 * Get public asset
 * @param mixed $path
 * @return string
 */
function asset($path)
{
	return Application::getHost() . "/$path";
}