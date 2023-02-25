<?php

namespace App\Controller;

use App\View\Layout\Dashboard;
use Core\Http\Controller;

class DashboardController extends Controller
{
	public function index()
	{
		if (auth()->guest()) {
			return redirect('login');
		}

		return view('dashboard/index')
			->with('user', auth()->user())
			->useLayout(new Dashboard());
	}
}