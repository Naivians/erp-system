<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;


// home
Route::get('/', [HomeController::class, 'index'])->name('login');

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

    // categories
    Route::get('/admin/category', [CategoryController::class, 'index'])->name('Admin.category');
    Route::post('/admin/create', [CategoryController::class, 'store'])->name('Admins.storeCategory');
    Route::get('/admin/{id}', [CategoryController::class, 'edit'])->name('Admins.editCategory');
    Route::put('/admin/update', [CategoryController::class, 'update'])->name('Admins.updateCategory');
    Route::get('/deleteCategory/{id}', [CategoryController::class, 'destroy'])->name('Admins.deleteCategory');

    // inventory
    Route::get('/admin/inventory/home', [InventoryController::class, 'index'])->name('Admins.InventoryHome');
    Route::post('/admin/inventory/register', [InventoryController::class, 'store'])->name('Admins.InventoryStore');
    Route::get('/deleteInventory/{id}', [InventoryController::class, 'destroy'])->name('Admins.InventoryDestroy');
    Route::get('/admin/{id}/edit', [InventoryController::class, 'edit'])->name('Admins.InventoryEdit');
});

//users
Route::middleware(['check.role:0'])->group(function (){
    Route::get('/pos', [HomeController::class, 'userPOS'])->name('Users.POS');
    Route::get('/pos/{category}', [PosController::class, 'showProductsByCategory'])->name('Users.category');
    Route::post('/update-session', [PosController::class, 'updateSession'])->name('pos.update-session');
    Route::get('/session-data', [PosController::class, 'getSessionData'])->name('pos.session-data');
    Route::post('/place-order', [PosController::class, 'placeOrder'])->name('pos.place-order');
    Route::get('/orders-table', [PosController::class, 'getOrders'])->name('Users.orders');

});

// auth
Route::post('/login', [AuthController::class, 'authUser'])->name('Logins.auth');
Route::get('/logout', [AuthController::class, 'logout'])->name('Logins.logout');
