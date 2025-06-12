<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\AuthController;

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas
Route::middleware('auth')->group(function () {
    Route::get('/', [FileController::class, 'index'])->name('files.index');
    Route::post('/upload', [FileController::class, 'store'])->name('files.store');
    Route::get('/logs', [FileController::class, 'logs'])->name('files.logs');
    Route::get('/download/{file}', [FileController::class, 'download'])->name('files.download');
});