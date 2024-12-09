<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\CartController;
use App\Http\Controllers\Frontends\HomeController;
use App\Http\Controllers\Frontends\NewsController;
use App\Http\Controllers\Frontends\ContactController;
use App\Http\Controllers\Frontends\ProductController;
use App\Http\Controllers\Frontends\IntroduceController;

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
    route::get('carts', 'list')->name('list');
    route::post('carts', 'addToCart')->name('add-to-cart');
});

route::controller(ProductController::class)->name('products.')->group(function () {
    route::get('danh-muc-san-pham/{slug}', 'list')->name('list');
    route::get('san-pham/{slug}', 'detail')->name('detail');
});

route::get('gioi-thieu', [IntroduceController::class, 'introduce'])->name('introduce');

route::controller(NewsController::class)->name('news.')->group(function () {
    route::get('tin-tuc', 'list')->name('list');
    route::get('tin-tuc/{slug}', 'detail')->name('detail');
});

route::get('contact', [ContactController::class, 'contact'])->name('contact');
