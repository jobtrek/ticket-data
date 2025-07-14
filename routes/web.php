<?php

use App\Http\Controllers\ComputerController;
use App\Http\Controllers\DataMatrixController;
use App\Http\Middleware\EnsureTokenIsSetup;
use App\Services\TokenService;
use Illuminate\Support\Facades\Route;

Route::get('/', [TokenService::class, 'getSessionToken']);
Route::resource('/computers', ComputerController::class)->middleware(EnsureTokenIsSetup::class);
Route::get('/data', [DataMatrixController::class, 'index']);
Route::post('/data', [DataMatrixController::class, 'cacheNewNumber'])->name('data');
Route::post('/deleteonedata', [DataMatrixController::class, 'deleteOneNumber'])->name('deleteonedata');
Route::post('/generatedata', [DataMatrixController::class, 'generateDataMatrix'])->name('generatedata');
Route::get('/flush', [TokenService::class, 'flushCacheSession'])->name('flush');