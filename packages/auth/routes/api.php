<?php
use Illuminate\Support\Facades\Route;
use Metft\Auth\Http\Controllers\AuthController;
Route::post("register", [AuthController::class, 'register'])->name('');
Route::post("authenticate", [AuthController::class, 'authenticate']);
