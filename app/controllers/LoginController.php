<?php

namespace App\Controller;

use Core\Http\Controller;
use App\View\Layout;
use Core\Foundation\Facade;

class LoginController extends Controller
{
	public function index()
	{
		return view('auth/login')->useLayout(new Layout\Auth());
	}

	public function authenticate()
	{
		$username = $this->request()->username;
		$password = $this->request()->password;

		if (Facade\Auth::attempt(compact('username', 'password'))) {
			dd($_SESSION);
		}

		return "Login gagal";
	}
}