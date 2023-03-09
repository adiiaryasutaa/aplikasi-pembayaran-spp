<?php

namespace App\Controller;

use Core\Http\Controller;
use App\View\Layout;
use Core\Foundation\Facade;

class AuthController extends Controller
{
	public function index()
	{
		if (auth()->user()) {
			return redirect('dashboard');
		}

		return view('auth/login')->useLayout(new Layout\Auth('Login'));
	}

	public function authenticate()
	{
		if (auth()->user()) {
			return redirect('dashboard');
		}

		$username = $this->request()->username;
		$password = $this->request()->password;

		if (Facade\Auth::attempt(compact('username', 'password'))) {
			return redirect('dashboard');
		}

		return back()->with('login-failed', 'Login gagal');
	}

	public function logout()
	{
		if (auth()->guest()) {
			return redirect('login');
		}

		auth()->logout();

		return redirect('login');
	}
}