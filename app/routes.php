<?php

use App\Controller\DashboardController;
use Core\Foundation\Facade\Route;

Route::get('/', [DashboardController::class, 'index'])->setName('home');