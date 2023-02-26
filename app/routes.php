<?php

use App\Controller\AuthController;
use App\Controller\DashboardController;
use App\Controller\PetugasController;
use Core\Foundation\Facade\Route;

Route::get('/', [DashboardController::class, 'index'])->setName('dashboard');

Route::get('/petugas', [PetugasController::class, 'index'])->setName('petugas');
Route::post('/petugas', [PetugasController::class, 'create'])->setName('add.petugas');

Route::get('/login', [AuthController::class, 'index'])->setName('login');
Route::post('/login', [AuthController::class, 'authenticate'])->setName('authentication');
Route::post('/logout', [AuthController::class, 'logout'])->setName('logout');