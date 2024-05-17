<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;

// home
Route::get('/', [HomeController::class, 'index'])->name('home');

// admin
Route::middleware(['check.role:1'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('Admins.home')->middleware('check.role:1');
});

// user
Route::middleware(['check.role:0'])->group(function () {
    Route::get('/user/home', [HomeController::class, 'userHome'])->name('Users.home')->middleware('check.role:0');
    Route::get('/pos', [HomeController::class, 'userPos'])->name('user.POS');
    Route::get('/pos/{category}', [PosController::class, 'showCategory']);
    Route::post('/add-to-session', [PosController::class, 'addToSession']);
    Route::get('/session-data', [PosController::class, 'getSessionData']);
    Route::post('/save-orders', [PosController::class, 'saveOrders'])->name('Users.orders');
    Route::post('/clear-session', [PosController::class, 'clearSession'])->name('Users.sessions');
});

// auth
Route::post('/login', [AuthController::class, 'authUser'])->name('Logins.auth');
Route::get('/logout', [AuthController::class, 'logout'])->name('Logins.logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('Logins.logout');
