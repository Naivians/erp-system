<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;

// home
Route::get('/',[HomeController::class, 'index'])->name('home');
Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('Admins.home')->middleware('check.role:1');
Route::get('/user/home', [HomeController::class, 'userHome'])->name('Users.home')->middleware('check.role:0');


// auth
Route::post('/login',[AuthController::class, 'authUser'])->name('Logins.auth');

// cashier
Route::get('/pos', [PosController::class, 'view'])->name('cashier.POS');
