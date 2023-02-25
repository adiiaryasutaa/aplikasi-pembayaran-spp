<?php

namespace Core\Auth;

use App\Model\Pengguna;
use App\Model\Petugas;
use App\Model\Siswa;
use Core\Foundation\Application;
use Core\Session\Store as Session;
use Exception;

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
		$password = $credentials['password'];
		unset($credentials['password']);

		$pengguna = (new Pengguna())->whereFirst($credentials);

		if ($pengguna->exists() && password_verify($password, $pengguna->password)) {
			$this->session->put([
				"$this->sessionKey.user.id" => $pengguna->id,
				"$this->sessionKey.user.role" => $pengguna->role,
			]);

			return true;
		}

		return false;
	}

	public function logout()
	{
		$this->session->remove("$this->sessionKey.user.id");
		$this->session->remove("$this->sessionKey.user.role");
	}

	public function guest()
	{
		return
			!$this->session->has("$this->sessionKey.user.id") &&
			!$this->session->has("$this->sessionKey.user.role");
	}

	public function user()
	{
		if ($this->guest()) {
			return null;
		}

		$id = $this->session->get("$this->sessionKey.user.id");
		$role = $this->session->get("$this->sessionKey.user.role");

		$pengguna = new Pengguna();
		$pengguna->where('id', $id);


		if ($role === Role::ADMIN->value || $role === Role::PETUGAS->value) {
			$petugas = new Petugas();

			if ($petugas->getByPenggunaId($id)->exists()) {
				return $petugas;
			}
		} else {
			$siswa = new Siswa();

			if ($siswa->getByPenggunaId($id)->exists()) {
				return $siswa;
			}
		}

		throw new Exception("User is authenticated but user doesn't exist");
	}
}