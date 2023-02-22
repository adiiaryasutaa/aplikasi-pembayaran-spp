<?php

use App\Controller\DashboardController;
use App\Controller\LoginController;
use App\Controller\PetugasController;
use Core\Foundation\Facade\Route;

Route::get('/', [DashboardController::class, 'index'])->setName('dashboard');

Route::get('/petugas', [PetugasController::class, 'index'])->setName('petugas');

Route::get('/login', [LoginController::class, 'index'])->setName('login');
Route::post('/login', [LoginController::class, 'authenticate'])->setName('authentication');