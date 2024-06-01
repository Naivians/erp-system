<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StockinController;
use App\Http\Controllers\StockoutController;
use App\Http\Controllers\WasteController;

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
    Route::put('/admin/updateCategory', [CategoryController::class, 'update'])->name('Admins.updateCategory');
    Route::get('/deleteCategory/{name}', [CategoryController::class, 'destroy'])->name('Admins.deleteCategory');

    // inventory
    Route::get('/admin/inventory/home', [InventoryController::class, 'index'])->name('Admins.InventoryHome');
    Route::post('/admin/inventory/register', [InventoryController::class, 'store'])->name('Admins.InventoryStore');
    Route::get('/deleteInventory/{code}', [InventoryController::class, 'destroy'])->name('Admins.InventoryDestroy');
    Route::get('/admin/{id}/edit', [InventoryController::class, 'edit'])->name('Admins.InventoryEdit');
    Route::put('/admin/update', [InventoryController::class, 'update'])->name('Admins.InventoryUpdate');

    // stockin
    Route::get('/admin/inventory/stockin', [StockinController::class, 'index'])->name('Admins.InventoryStockinIndex');
    Route::get('/admin/inventory/stocklist', [StockinController::class, 'stocklist'])->name('Admins.InventoryStockList');
    Route::post('/stockin/saveForm', [StockinController::class, 'saveForm'])->name('Admins.InventoryStockinCreate');
    Route::get('/stockin/{id}/destroy', [StockinController::class, 'destroy'])->name('Admins.StockinsDestroy');
    Route::get('/stockin/{id}/edit', [StockinController::class, 'edit'])->name('Admins.StockinsEdit');
    Route::put('/stockin/update', [StockinController::class, 'update'])->name('Admins.InventoryStockinsUpdate');

    // Stockout
    Route::get('/admin/inventory/StockoutForm', [StockOutController::class, 'formPage'])->name('Admins.InventoryStockOutForm');
    Route::get('/admin/inventory/stockoutlist', [StockoutController::class, 'index'])->name('Admins.InventoryStockoutList');
    Route::post('/stockout/saveForm', [StockoutController::class, 'saveForm'])->name('Admins.InventoryStockoutCreate');
    Route::get('/stockout/{id}/destroy', [StockoutController::class, 'destroy'])->name('Admins.StockoutsDestroy');
    Route::get('/stockout/{id}/edit', [StockoutController::class, 'edit'])->name('Admins.StockoutsEdit');
    Route::put('/stockout/update', [StockoutController::class, 'update'])->name('Admins.InventoryStockoutUpdate');

    // waste
    Route::get('/admin/waste/waste', [WasteController::class, 'index'])->name('Admins.Wastehome');
    Route::get('/admin/{code}/movetoarchive', [WasteController::class, 'store'])->name('Admins.WasteStore');

    // "/admin/" + code + '/movetoarchive'

    // search
    Route::get('/searchItemCode', [SearchController::class, 'codeSearch'])->name('Admins.search');
    Route::get('/search/refresh', [SearchController::class, 'refresh'])->name('Admins.refresh');
    Route::get('/deleteItemcode/{itemCode}', [SearchController::class, 'destroy'])->name('Admins.searchDestroy');
    Route::get('/searchAll', [SearchController::class, 'search'])->name('Search.All');
    Route::get('/searchDate', [SearchController::class, 'searchDate'])->name('Search.betweenDate');
    Route::get('/cancelForm', [SearchController::class, 'destroySession'])->name('Search.SessionDestroy');
});


//users
Route::middleware(['check.role:0'])->group(function () {
    Route::get('/pos', [HomeController::class, 'userPOS'])->name('Users.POS');
    Route::get('/pos/{category}', [PosController::class, 'showProductsByCategory'])->name('Users.category');
    Route::post('/update-session', [PosController::class, 'updateSession'])->name('pos.update-session');
    Route::post('/update-session', [PosController::class, 'updateSession'])->name('pos.update-session');
    Route::get('/session-data', [PosController::class, 'getSessionData'])->name('pos.session-data');
    Route::post('/place-order', [PosController::class, 'placeOrder'])->name('pos.place-order');
    Route::get('/orders-table', [PosController::class, 'getOrders'])->name('Users.orders');
    Route::get('/print-receipt/{orderId}', [PosController::class, 'printReceipt'])->name('Users.printReceipt');
});

// auth
Route::post('/login', [AuthController::class, 'authUser'])->name('Logins.auth');
Route::get('/logout', [AuthController::class, 'logout'])->name('Logins.logout');
