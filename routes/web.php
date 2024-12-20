<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;


Route::get('/', [FileController::class, 'index'])->name('files.index');
Route::post('/upload', [FileController::class, 'store'])->name('files.store');