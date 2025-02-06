<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\CartController;
use App\Http\Controllers\Frontends\Auth\AuthController;
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

route::name('auth.')->controller(AuthController::class)->group(function () {
    route::middleware('guest')->group(function () {
        route::get('dang-nhap',  'login')->name('login');
        route::post('dang-nhap', 'authenticate')->name('authenticate');
        route::post('dang-ky', 'register')->name('register');
        route::get('auth/google', 'redirect')->name('google-auth');
        route::get('auth/google/call-back', 'callbackGoogle');
    });


    route::middleware('auth')->group(function () {
        route::get('dang-xuat', 'logout')->name('logout');
        route::get('profile', 'profile')->name('profile');
        route::post('change-info', 'handleChangeInfo')->name('handle-change-info');
        route::post('change-password', 'handleChangePassword')->name('handle-change-password');
    });
});


route::get('/', [HomeController::class, 'home'])->name('home');

route::controller(CartController::class)->name('carts.')->group(function () {
    route::get('carts', 'list')->name('list');
    route::get('thanh-toan', 'InfoPayment')->name('thanh-toan');
    route::post('carts', 'addToCart')->name('add-to-cart');
    route::post('del-cart/{id}', 'delItemCart')->name('del-to-cart');
    route::post('update-cart/{id}', 'updateQtyCart')->name('update-to-cart');
    route::get('payment-request', 'paymentRequest')->name('payment-request');
    Route::get('order-lookup/{code?}', [CartController::class, 'lookup'])->name('order.lookup');
    Route::get('order-detail/{code}', [CartController::class, 'lookup'])->name('order-detail');
    Route::post('handle-remaining-payment', [CartController::class, 'handleRemainingPayment'])->name('handle-remaining-payment');
    Route::get('order-updated-successfully', [CartController::class, 'orderUpdatedSuccessfully'])->name('order-updated-successfully');

    // route::post('update-cart/{id}/{qty}', 'updateQtyCart')->name('update-to-cart');

    // Route::post('restore/{rowId}', [CartController::class, 'restoreLastDeletedProduct'])->name('restore');
    Route::post('restore', [CartController::class, 'restore'])->name('restore');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('order-success/{code}', [CartController::class, 'orderSuccess'])->name('order-success');
    Route::get('/districts', [CartController::class, 'getDistricts'])->name('api.districts');
    Route::get('/wards', [CartController::class, 'getWards'])->name('api.wards');
});

Route::controller(ProductController::class)->name('products.')->group(function () {
    Route::get('danh-muc-san-pham/{slug?}', 'list')->name('list');
    Route::get('san-pham/{slug}', 'detail')->name('detail');
    Route::get('filter-product/{slug?}', 'filterProduct')->name('filter-product');
    Route::get('danh-muc', 'listCategory')->name('list-category');
    Route::post('end-view', 'endView')->name('end-view'); // Đảm bảo rằng bạn có tên route đúng ở đây
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
