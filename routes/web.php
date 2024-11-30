<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListController;
use App\Http\Controllers\Auth\AuthController;
use App\Models\User;
use App\Models\Admin;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\AdminController; 
use App\Http\Controllers\Admin\ProductController; 
use App\Http\Controllers\User\UserController; 


Route::get('/', [ListController::class, 'index']);



// Guest Route
Route::group(['middleware' => 'guest'], function() {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::post('/post-login', [AuthController::class, 'login'])->middleware('guest');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/post-register', [AuthController::class, 'post_register'])->name('post.register');
});

// Admin Route
Route::group(['middleware' => 'admin'], function() {
      Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard'); 
    
       // Product Route 
    Route::get('/product', [ProductController::class, 'index'])->name('admin.product'); 

    Route::get('/admin-logout', [AuthController::class, 'admin_logout'])->name('admin.logout'); 
    })->middleware('admin'); 

    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');

    Route::get('/admin/product/detail/{id}', [ProductController::class, 'detail'])->name('product.detail');

    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('admin/product/update/{id}', [ProductController::class, 'update'])->name('admin.product.update');


    Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

    Route::middleware(['auth', 'isAdmin'])->group(function () {

    
    Route::get('/flash-sale/create', [FlashSaleController::class, 'create'])->name('admin.flash_sale.create');
    Route::post('/flash-sale', [FlashSaleController::class, 'store'])->name('admin.flash_sale.store');

});


// User Route
Route::group(['middleware' => 'web'], function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.dashboard');

    // Route::get('/user', function () {
    //     return view('pages.user.index');
    // })->name('user.dashboard');

    Route::get('/user-logout', [AuthController::class, 'user_logout'])
        ->name('user.logout')
        ->middleware('web');

    Route::get('/user/product/detail/{id}', [UserController::class, 'detail_product'])->name('user.detail.product');
    Route::get('/product/purchase/{productId}/{userId}', [UserController::class, 'purchase']);

    // Product Route
    Route::get('/user/product/detail/{id}', [UserController::class, 'detail_product'])->name('user.detail.product');
    Route::get('/product/purchase/{productId}/{userId}', [UserController::class, 'purchase']);
    
    Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');

    Route::get('/flash-sale', [FlashSaleController::class, 'index'])->name('user.flash_sale.index');


});
