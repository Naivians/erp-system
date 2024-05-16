<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

// home
Route::get('/',[HomeController::class, 'index'])->name('login');

// admin
Route::middleware(['check.role:1'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('Admins.home');
    // users
    Route::get('/admin/user', [UserController::class, 'index'])->name('Admins.user');
    Route::post('/admin/user/store', [UserController::class, 'store'])->name('Admins.store');
    Route::post('/admin/register', [UserController::class, 'store'])->name('Admins.store');
    Route::get('/deleteUser/{id}', [UserController::class, 'destroy'])->name('Admins.destroy');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('Admins.edit');
    Route::put('/update', [UserController::class, 'update'])->name('Admins.update');
});

// user
Route::middleware(['check.role:0'])->group(function (){
    Route::get('/user/home', [HomeController::class, 'userHome'])->name('Users.home')
    Route::get('/pos', [HomeController::class, 'userPos'])->name('user.POS');
    Route::get('/pos/{categories}', [PosController::class, 'getItemsByCategory']);
});

// auth
Route::post('/login',[AuthController::class, 'authUser'])->name('Logins.auth');
Route::get('/logout',[AuthController::class, 'logout'])->name('Logins.logout');

