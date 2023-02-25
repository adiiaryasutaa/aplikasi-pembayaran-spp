<?php

namespace Core\Http;

use Core\Foundation\Facade\Route;
use COre\Foundation\Facade\Session;

class RedirectResponse extends Response
{
	protected string $to;

	public function __construct(string $to, int $status = 302)
	{
		$this->to($to);
		$this->setStatus($status);
	}

	public function to(string $to)
	{
		$route = Route::getRouteByName($to);

		if (is_null($route)) {
			$route = Route::getRoute('GET', $to);
		}

		$this->to = is_null($route) ? $to : $route->getFullUri();

		return $this;
	}

	public function send()
	{
		$content = "
		<!DOCTYPE html>
		<html>
			<head>
				<meta http-equiv=\"refresh\" content=\"0; url='$this->to'\" />
			</head>
			<body>
				<p>Redirecting to $this->to.</p>
			</body>
		</html>";

		$this->setContent($content);

		return parent::send();
	}

	public function with(string|array $keys, $value = null)
	{
		Session::setFlash($keys, $value);

		return $this;
	}
}