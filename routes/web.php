<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function(){
    Route::get('' , function(){
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('change-password.index');
    Route::post('/change-password', [ChangePasswordController::class, 'update'])->name('change-password.update');

    // * Category Route
    Route::get('/category/data', [CategoryController::class, 'data'])->name('category.data');
    Route::post('/category/delete-all', [CategoryController::class, 'deleteMultiple'])->name('category.delete-all');
    Route::resource('/category', CategoryController::class)->except('create', 'show');

    // * Product Route
    Route::get('/product/data', [ProductController::class, 'data'])->name('product.data');
    Route::post('/product/delete-all', [ProductController::class, 'deleteMultiple'])->name('product.delete-all');
    Route::resource('/product', ProductController::class)->except('create');

    // * Supplier Route
    Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
    Route::resource('/supplier', SupplierController::class);

    // * Customer Route
    Route::get('/customer/data', [CustomerController::class, 'data'])->name('customer.data');
    Route::resource('/customer', CustomerController::class);

    // * Stock Route
    Route::get('/stock/data', [StockController::class, 'data'])->name('stock.data');
    Route::resource('/stock', StockController::class);

    // * Permission Route
    Route::get('/permission/data', [PermissionController::class, 'data'])->name('permission.data');
    Route::resource('/permission', PermissionController::class);
});


require __DIR__.'/auth.php';
