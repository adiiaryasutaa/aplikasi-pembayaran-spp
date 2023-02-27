<?php

use App\Controller\AuthController;
use App\Controller\DashboardController;
use App\Controller\KelasController;
use App\Controller\PetugasController;
use App\Controller\SiswaController;
use Core\Foundation\Facade\Route;

Route::get('/', [DashboardController::class, 'index'])->setName('dashboard');

Route::get('/petugas', [PetugasController::class, 'index'])->setName('petugas');
Route::post('/petugas', [PetugasController::class, 'create'])->setName('petugas.create');
Route::get('/petugas/{username}', [PetugasController::class, 'show'])->setName('petugas.show');
Route::post('/petugas/{username}/update', [PetugasController::class, 'update'])->setName('petugas.update');
Route::post('/petugas/{username}/delete', [PetugasController::class, 'delete'])->setName('petugas.delete');

Route::get('/kelas', [KelasController::class, 'index'])->setName('kelas');
Route::post('/kelas', [KelasController::class, 'create'])->setName('kelas.create');
Route::get('/kelas/{id:\d+}', [KelasController::class, 'show'])->setName('kelas.show');
Route::post('/kelas/{id:\d+}/update', [KelasController::class, 'update'])->setName('kelas.update');
Route::post('/kelas/{id:\d+}/delete', [KelasController::class, 'delete'])->setName('kelas.delete');

Route::get('/siswa', [SiswaController::class, 'index'])->setName('siswa');
Route::post('/siswa', [SiswaController::class, 'create'])->setName('siswa.create');
Route::get('/siswa/{id:\d+}', [SiswaController::class, 'show'])->setName('siswa.show');
Route::post('/siswa/{id:\d+}/update', [SiswaController::class, 'update'])->setName('siswa.update');
Route::post('/siswa/{id:\d+}/delete', [SiswaController::class, 'delete'])->setName('siswa.delete');

Route::get('/login', [AuthController::class, 'index'])->setName('login');
Route::post('/login', [AuthController::class, 'authenticate'])->setName('authentication');
Route::post('/logout', [AuthController::class, 'logout'])->setName('logout');