<?php




use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\Auth\AuthController;
use App\Http\Controllers\admin\ConfigController;
use App\Http\Controllers\admin\FuelController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\NewsController;
use App\Http\Controllers\admin\OriginController;
use App\Http\Controllers\admin\PromotionController;
use App\Models\SgoFuel;

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

    route::middleware('guest')->group(function () {
        route::get('login', [AuthController::class, 'login'])->name('login');
        route::post('login', [AuthController::class, 'authenticate']);
    });

    route::middleware('auth')->group(function () {

        Route::get('/', function () {
            $title = ' Dashboard';
            return view('backend.dashboard', compact('title'));
        })->name('dashboard');

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
            Route::get('', [ProductController::class, 'index'])->name('index');
            Route::get('add', [ProductController::class, 'add'])->name('add');
            Route::post('store', [ProductController::class, 'store'])->name('store');
            Route::get('detail/{id}', [ProductController::class, 'edit'])->name('detail');
            Route::post('update/{id}', [ProductController::class, 'update'])->name('update');
            Route::post('delete/{id}', [ProductController::class, 'delete'])->name('delete');
        });
    });

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
        Route::get('', [ConfigController::class, 'index'])->name('index');
        Route::post('update', [ConfigController::class, 'update'])->name('update');
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
