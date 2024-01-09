<?php

use App\Http\Controllers\AgamaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreateAnggotaController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\EditAnggotaController;
use App\Http\Controllers\HubungankkController;
use App\Http\Controllers\KkController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/daftar', [AuthController::class, 'signup'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');

Route::resource('agama', AgamaController::class)->middleware('auth');

Route::resource('hubungankk', HubungankkController::class)->middleware('auth');

Route::resource('kk', KkController::class)->middleware('auth');

Route::get('/penduduk', [PendudukController::class, 'indexPenduduk'])->middleware('auth');
Route::get('/penduduk/create', [PendudukController::class, 'formPenduduk'])->middleware('auth');
Route::post('/penduduk/simpan', [PendudukController::class, 'simpanPenduduk'])->middleware('auth');
Route::get('/penduduk/{id}/edit', [PendudukController::class, 'editPenduduk'])->middleware('auth');
Route::put('/penduduk/{id}/update', [PendudukController::class, 'updatePenduduk'])->middleware('auth');
Route::delete('/penduduk/{id}', [PendudukController::class, 'destroy'])->middleware('auth');

Route::get('/daftar/{id}/keluarga', [DetailsController::class, 'indexAnggotakk'])->name('keluarga')->middleware('auth');

Route::get('/anggotakk/create/{id}', [CreateAnggotaController::class, 'formAnggotakk'])->name('anggotakk')->middleware('auth');
Route::post('/anggotakk/simpan', [CreateAnggotaController::class, 'simpanAnggotakk'])->middleware('auth');

Route::get('/anggotakk/{id}/edit', [EditAnggotaController::class, 'editAnggotakk'])->middleware('auth');
Route::put('/anggotakk/{id}/update', [EditAnggotaController::class, 'updateAnggotakk'])->middleware('auth');
Route::delete('/anggotakk/{id}', [DetailsController::class, 'destroy'])->middleware('auth');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
