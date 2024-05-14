<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// admin
Route::get('/admin/home', [DashboardController::class, 'adminHome'])->name('Admin.home');


// auth
Route::get('/',[AuthController::class, 'index'])->name('index');
Route::post('/login',[AuthController::class, 'authUser'])->name('Logins.auth');

