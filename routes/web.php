<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/',[AuthController::class, 'index'])->name('index');
Route::post('/login',[AuthController::class, 'authUser'])->name('Logins.auth');

