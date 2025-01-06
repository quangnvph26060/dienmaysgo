<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\CartController;
use App\Http\Controllers\Frontends\HomeController;
use App\Http\Controllers\Frontends\NewsController;
use App\Http\Controllers\Frontends\ContactController;
use App\Http\Controllers\Frontends\ProductController;
use App\Http\Controllers\Frontends\IntroduceController;
use App\Http\Controllers\PaymentController;

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



route::get('/', [HomeController::class, 'home'])->name('home');

route::controller(CartController::class)->name('carts.')->group(function () {
    route::get('carts', 'list')->name('list');
    route::get('thanh-toan', 'InfoPayment')->name('thanh-toan');
    route::post('carts', 'addToCart')->name('add-to-cart');
    route::post('del-cart/{id}', 'delItemCart')->name('del-to-cart');
    route::post('update-cart/{id}', 'updateQtyCart')->name('update-to-cart');
    route::get('payment-request', 'paymentRequest')->name('payment-request');
    // route::post('update-cart/{id}/{qty}', 'updateQtyCart')->name('update-to-cart');

    // Route::post('restore/{rowId}', [CartController::class, 'restoreLastDeletedProduct'])->name('restore');
    Route::post('restore', [CartController::class, 'restore'])->name('restore');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('order-success/{code}', [CartController::class, 'orderSuccess'])->name('order-success');
    Route::get('/districts', [CartController::class, 'getDistricts'])->name('api.districts');
    Route::get('/wards', [CartController::class, 'getWards'])->name('api.wards');
});

route::controller(ProductController::class)->name('products.')->group(function () {
    route::get('danh-muc-san-pham/{slug}', 'list')->name('list');
    route::get('san-pham/{slug}', 'detail')->name('detail');
    route::get('filter-product/{slug}', 'filterProduct')->name('filter-product');
});


Route::prefix('home')->group(function () {
    route::get('{slug}', [IntroduceController::class, 'introduce'])->name('introduce');
});


route::controller(NewsController::class)->name('news.')->group(function () {
    route::get('tin-tuc/{slug?}', 'list')->name('list');
    // route::get('tin-tuc/{slug}', 'detail')->name('detail');
});

route::get('contact', [ContactController::class, 'contact'])->name('contact');
route::post('lien-he', [ContactController::class, 'postContact'])->name('post-contact');

Route::post('/payment/create', [PaymentController::class, 'createPaymentRequest'])->name('payment.create');
