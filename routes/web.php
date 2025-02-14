<?php

use App\Http\Controllers\admin\AttributeController;
use App\Http\Controllers\admin\AttributeValueController;
use App\Http\Controllers\admin\BulkActionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\Auth\AuthController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\ConfigController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\FuelController;
use App\Http\Controllers\admin\HistorySearchController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\NewsController;
use App\Http\Controllers\admin\OriginController;
use App\Http\Controllers\admin\PromotionController;
use App\Models\SgoFuel;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\UserController;

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






Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('detail/{id}', [UserController::class, 'getUserInfor'])->name('getUserInfor');
    Route::post('update/{id}', [UserController::class, 'updateUserInfor'])->name('updateUserInfor');
    Route::post('change-password', [UserController::class, 'changePassword'])->name('changePassword');
    route::middleware('admin.guest')->group(function () {
        route::get('login', [AuthController::class, 'login'])->name('login');
        route::post('login', [AuthController::class, 'authenticate']);
    });

    route::middleware('admin.auth')->group(function () {

        // Route::get('/', function () {
        //     $title = ' Dashboard';
        //     return view('backend.dashboard', compact('title'));
        // })->name('dashboard');
        route::get('/', [DashboardController::class, 'getRevenueChart'])->name('dashboard');

        route::get('logout', [AuthController::class, 'logout'])->name('logout');

        Route::prefix('category')->name('category.')->group(function () {
            Route::get('', [CategoryController::class, 'index'])->name('index');
            Route::get('create', [CategoryController::class, 'create'])->name('create');
            Route::post('create', [CategoryController::class, 'store'])->name('store');
            Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
            Route::post('edit/{id}', [CategoryController::class, 'update'])->name('update');
            Route::post('delete/{id}', [CategoryController::class, 'delete'])->name('delete');
        });
        
        Route::prefix('product')->name('product.')->group(function () {
            Route::get('categories', [ProductController::class, 'getCategories'])->name('categories.index');
            Route::get('attributes', [ProductController::class, 'getAttributes'])->name('attributes.index');
            Route::get('attributes/{id}/values', [ProductController::class, 'getValues'])->name('attributes.values');
            Route::get('', [ProductController::class, 'index'])->name('index');
            Route::get('add', [ProductController::class, 'add'])->name('add');
            Route::post('store', [ProductController::class, 'store'])->name('store');
            Route::get('detail/{id}', [ProductController::class, 'edit'])->name('detail');
            Route::post('update/{id}', [ProductController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [ProductController::class, 'delete'])->name('delete');
            route::post('change-select', [ProductController::class, 'changeSelect'])->name('changeSelect');
            route::post('update-price/{id}', [ProductController::class, 'handleChangePrice'])->name('handle-change-price');
            route::post('import-data', [ProductController::class, 'importData'])->name('import-data');
            route::post('modify-product', [ProductController::class, 'modifyProduct'])->name('modify-product');
        });

        route::prefix('marketing')->name('marketing.')->controller(HistorySearchController::class)->group(function () {
            route::get('history-search', 'index')->name('history-search');
        });

        // Route::prefix('order')->name('order.')->group(function () {
        //     Route::get('', [OrderController::class, 'index'])->name('index');
        //     Route::get('detail/{id}', [OrderController::class, 'detail'])->name('detail');
        //     Route::post('updateStatus', [OrderController::class, 'updateOrderStatus'])->name('updateOrderStatus');
        //     Route::post('export-pdf', [OrderController::class, 'exportPDF'])->name('exportPDF');
        //     route::post('change-status', )
        // });

        Route::prefix('order')->name('order.')->controller(OrderController::class)->group(function () {
            Route::get('',  'index')->name('index');
            Route::get('detail/{id}',  'detail')->name('detail');
            Route::post('updateStatus',  'updateOrderStatus')->name('updateOrderStatus');
            Route::post('export-pdf',  'exportPDF')->name('exportPDF');
            route::post('change-status', 'changeOrderStatus')->name('change-order-status');
            route::post('cancel-order/{id}', 'cancelOrder')->name('cancel-order');
            route::get('confirm-payment/{id}', 'confirmPayment')->name('confirm-payment');
            route::get('ransfer-history', 'transferHistory')->name('transfer-history');
        });
    });

    // Attribute Route
    route::resource('attributes', AttributeController::class);

    // Brand Route
    route::resource('brands', BrandController::class);

    // Attribute Value Route
    route::resource('attribute-values', AttributeValueController::class);

    Route::post('/delete-items', [BulkActionController::class, 'deleteItems'])->name('delete.items');
    Route::post('/change-order', [BulkActionController::class, 'changeOrder'])->name('changeOrder');


    Route::prefix('origin')->name('origin.')->group(function () {
        Route::get('', [OriginController::class, 'index'])->name('index');
        Route::get('create', [OriginController::class, 'create'])->name('create');
        Route::post('store', [OriginController::class, 'store'])->name('store');
        Route::get('edit/{id}', [OriginController::class, 'edit'])->name('edit');
        Route::PUT('edit/{id}', [OriginController::class, 'update'])->name('update');
        Route::delete('delete/{id}', [OriginController::class, 'delete'])->name('delete');
    });

    Route::prefix('promotion')->name('promotion.')->group(function () {
        Route::get('', [PromotionController::class, 'index'])->name('index');
        Route::get('create', [PromotionController::class, 'create'])->name('create');
        Route::post('store', [PromotionController::class, 'store'])->name('store');
        Route::get('edit/{id}', [PromotionController::class, 'edit'])->name('edit');
        Route::post('edit/{id}', [PromotionController::class, 'update'])->name('update');
        Route::post('delete/{id}', [PromotionController::class, 'delete'])->name('delete');
    });

    Route::prefix('news')->name('news.')->group(function () {
        Route::get('', [NewsController::class, 'index'])->name('index');
        Route::get('create', [NewsController::class, 'create'])->name('create');
        Route::post('store', [NewsController::class, 'store'])->name('store');
        Route::get('edit/{id}', [NewsController::class, 'edit'])->name('edit');
        Route::post('edit/{id}', [NewsController::class, 'update'])->name('update');
        Route::post('delete/{id}', [NewsController::class, 'delete'])->name('delete');
    });
    Route::prefix('home')->name('home.')->group(function () {
        Route::get('', [HomeController::class, 'index'])->name('index');
        Route::get('create', [HomeController::class, 'create'])->name('create');
        Route::post('store', [HomeController::class, 'store'])->name('store');
        Route::get('edit/{id}', [HomeController::class, 'edit'])->name('edit');
        Route::post('edit/{id}', [HomeController::class, 'update'])->name('update');
        Route::post('delete/{id}', [HomeController::class, 'delete'])->name('delete');
    });

    Route::prefix('config')->name('config.')->group(function () {
        Route::get('config-support', [ConfigController::class, 'configSupport'])->name('config-support');
        Route::get('', [ConfigController::class, 'index'])->name('index');
        Route::post('update', [ConfigController::class, 'update'])->name('update');
        Route::post('update-support', [ConfigController::class, 'updateSupport'])->name('update-support');
        route::get('config-payment/{id?}', [ConfigController::class, 'configPayment'])->name('config-payment');
        route::post('config-payment', [ConfigController::class, 'configPaymentPost']);
        route::put('config-payment', [ConfigController::class, 'handleChangePublishPayment'])->name('handle-change-publish-payment');
        route::get('config-slider', [ConfigController::class, 'configSlider'])->name('config-slider');
        route::post('config-slider', [ConfigController::class, 'handleSubmitSlider'])->name('handle-submit-slider');
        route::get('config-filter', [ConfigController::class, 'configFilter'])->name('config-filter');
        route::post('config-filter', [ConfigController::class, 'handleSubmitFilter']);
        route::post('config-filter-update/{id}', [ConfigController::class, 'handleSubmitChangeFilter'])->name('config-filter-update');
        route::post('config-transfer-payment', [ConfigController::class, 'configTransferPayment'])->name('config-transfer-payment');
    });

    Route::prefix('fuel')->name('fuel.')->group(function () {
        Route::get('', [FuelController::class, 'index'])->name('index');
        Route::get('create', [FuelController::class, 'create'])->name('create');
        Route::post('store', [FuelController::class, 'store'])->name('store');
        Route::get('edit/{id}', [FuelController::class, 'edit'])->name('edit');
        Route::PUT('edit/{id}', [FuelController::class, 'update'])->name('update');
        Route::delete('delete/{id}', [FuelController::class, 'delete'])->name('delete');
    });
});




Route::post('upload', function (Request $request) {
    if ($request->hasFile('upload')) {
        $image = $request->file('upload');
        $filename = time() . uniqid() . '.' . $image->getClientOriginalExtension();
        Storage::disk('public')->put('images' . '/' . $filename, file_get_contents($image->getPathName()));
        $path = 'images' . '/' . $filename;
        $url = Storage::url($path);
        $CKEditorFuncNum = $request->input('CKEditorFuncNum');
        $msg = 'Image uploaded successfully';

        return "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg');</script>";
    }
})->name('ckeditor.upload');



route::get('filemanager-browse', function () {

    $paths = glob(public_path('storage/images/*'));

    $fileName = [];

    foreach ($paths as $path) {
        $fileName[] = basename($path);
    }
    return view('browser-server', compact('fileName'));
})->name('filemanager.browse');
