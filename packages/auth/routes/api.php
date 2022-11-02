<?php
use Illuminate\Support\Facades\Route;
use Metft\Auth\Http\Controllers\AuthController;
Route::post("register", [AuthController::class, 'register'])->name('');
Route::post("login", [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');