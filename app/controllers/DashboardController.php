<?php

namespace App\Controller;

use App\View\Layout\Dashboard;

class DashboardController
{
	public function index()
	{
		return view('dashboard/index')->useLayout(new Dashboard());
	}
}