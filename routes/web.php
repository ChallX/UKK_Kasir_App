<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\adminPenjualanController;
use App\Http\Controllers\authcontroller;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\petugasController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\staffProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get("/", [authController::class, 'login'])->name('login');
Route::post('/loginHandle', [authcontroller::class, 'loginHandle'])->name('loginHandle');
Route::post('/logout', [authcontroller::class, 'logout'])->name('logout');

Route::middleware(['CheckRole:admin'])->group(function () {
    Route::prefix('/admin')->name('admin.')->group(function () {
        Route::get('/', [adminController::class, 'index'])->name('index');

        Route::prefix('/product')->name('product.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::post('/store', [ProductController::class, 'store'])->name('store');
            Route::patch('/{id}', [ProductController::class, 'update'])->name('update');
            Route::delete('/{id}', [ProductController::class, 'destroy'])->name('delete');
        });

        Route::prefix('/penjualan')->name('penjualan.')->group(function () {
            Route::get('/', [adminPenjualanController::class, 'index'])->name('index');
        });

        Route::prefix('/user')->name('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::patch('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class,'destroy'])->name('delete');
        });
    });
});


Route::middleware(['CheckRole:petugas'])->group(function () {
    Route::prefix('/petugas')->name('petugas.')->group(function () {
        Route::get('/', [petugasController::class, 'index'])->name('index');

        Route::prefix('/product')->name('product.')->group(function () {
            Route::get('/', [staffProductController::class, 'index'])->name('index');
        });

        Route::prefix('/penjualan')->name('penjualan.')->group(function () {
            Route::get('/', [PenjualanController::class, 'index'])->name('index');
            Route::get('/create', [PenjualanController::class, 'create'])->name('create');
            Route::post('/checkout', [PenjualanController::class, 'checkout'])->name('checkout');
        });
    });
});
