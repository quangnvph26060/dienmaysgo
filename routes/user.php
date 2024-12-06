<?php

use App\Http\Controllers\admin\CartController;
use App\Http\Controllers\Frontends\HomeController;
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



route::get('/', [HomeController::class, 'home']);

route::controller(CartController::class)->name('carts.')->group(function () {
    route::post('carts', 'addToCart')->name('add-to-cart');
});
