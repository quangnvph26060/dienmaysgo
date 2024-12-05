<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('backend.dashboard');
});

Route::prefix('admin')->name('admin.')->group(function () {

    Route::prefix('category')->name('category.')->group(function () {
        Route::get('', [CategoryController::class, 'index'])->name('index');
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        Route::post('create', [CategoryController::class, 'store'])->name('store');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('edit/{id}', [CategoryController::class, 'update'])->name('update');
        Route::post('delete/{id}', [CategoryController::class, 'delete'])->name('delete');
    });
    Route::prefix('product')->name('product.')->group(function () {
        Route::get('', [ProductController::class, 'index'])->name('index');
        Route::get('add', [ProductController::class, 'add'])->name('add');
        Route::post('store', [ProductController::class, 'store'])->name('store');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('edit/{id}', [CategoryController::class, 'update'])->name('update');
        Route::post('delete/{id}', [CategoryController::class, 'delete'])->name('delete');
    });
});
