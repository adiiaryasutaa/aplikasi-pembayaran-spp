<?php

use App\Controller\AuthController;
use App\Controller\DashboardController;
use App\Controller\HistoryController;
use App\Controller\KelasController;
use App\Controller\LaporanController;
use App\Controller\PembayaranController;
use App\Controller\PenggunaController;
use App\Controller\PetugasController;
use App\Controller\SiswaController;
use App\Controller\TransaksiController;
use Core\Foundation\Facade\Route;

Route::get('/', [DashboardController::class, 'index'])->setName('dashboard');

Route::get('/petugas', [PetugasController::class, 'index'])->setName('petugas');
Route::post('/petugas', [PetugasController::class, 'create'])->setName('petugas.create');
Route::get('/petugas/{id:\d+}', [PetugasController::class, 'show'])->setName('petugas.show');
Route::post('/petugas/{id:\d+}/update', [PetugasController::class, 'update'])->setName('petugas.update');
Route::post('/petugas/{id:\d+}/delete', [PetugasController::class, 'delete'])->setName('petugas.delete');

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

Route::get('/pembayaran', [PembayaranController::class, 'index'])->setName('pembayaran');
Route::post('/pembayaran', [PembayaranController::class, 'create'])->setName('pembayaran.create');
Route::get('/pembayaran/{id:\d+}', [PembayaranController::class, 'show'])->setName('pembayaran.show');
Route::post('/pembayaran/{id:\d+}/update', [PembayaranController::class, 'update'])->setName('pembayaran.update');
Route::post('/pembayaran/{id:\d+}/delete', [PembayaranController::class, 'delete'])->setName('pembayaran.delete');

Route::get('/transaksi', [TransaksiController::class, 'index'])->setName('transaksi');
Route::post('/siswa/{id:\d+}/bayar', [TransaksiController::class, 'pay'])->setName('transaksi.pay');

Route::get('/history', [HistoryController::class, 'index'])->setName('history');

Route::get('/pengguna', [PenggunaController::class, 'index'])->setName('pengguna');
Route::get('/pengguna/{username:\w+}', [PenggunaController::class, 'show'])->setName('pengguna.show');

Route::get('/laporan', [LaporanController::class, 'index'])->setName('laporan');
Route::post('/laporan', [LaporanController::class, 'generate'])->setName('laporan.create');

Route::get('/login', [AuthController::class, 'index'])->setName('login');
Route::post('/login', [AuthController::class, 'authenticate'])->setName('authentication');
Route::post('/logout', [AuthController::class, 'logout'])->setName('logout');