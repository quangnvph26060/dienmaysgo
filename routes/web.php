<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\CategoryController;

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
        Route::get('detail/{id}', [ProductController::class, 'edit'])->name('detail');
        Route::post('update/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('delete/{id}', [ProductController::class, 'delete'])->name('delete');
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
