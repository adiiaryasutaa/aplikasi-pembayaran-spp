<?php

namespace Core\Auth;

use App\Model\Pengguna;
use Core\Foundation\Application;
use Core\Session\Store as Session;

class AuthManager
{
	protected string $sessionKey = '_auth';

	protected Session $session;

	public function __construct()
	{
		$this->session = Application::getSession();
	}

	public function attempt(array $credentials = [])
	{
		$pengguna = new Pengguna();

		$password = $credentials['password'];
		unset($credentials['password']);

		$pengguna->where($credentials);


		if ($pengguna->exists() && password_verify($password, $pengguna->password)) {
			$this->session->put([
				"$this->sessionKey.user.id" => $pengguna->id,
				"$this->sessionKey.user.role" => $pengguna->role,
			]);

			return true;
		}

		return false;
	}
}