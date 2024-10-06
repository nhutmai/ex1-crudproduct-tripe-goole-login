<?php

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    //route cho các user
    Route::post('stripe',[StripeController::class,'stripe'])->name('stripe');
    Route::get('success',[StripeController::class,'success'])->name('success');
    Route::get('cancel',[StripeController::class,'cancel'])->name('cancel');


    // Các route cho admin
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        //crud sản phâẩm
        Route::resource('products', ProductController::class);
    });

});

Route::get('/products', [UserProductController::class, 'index'])->name('user.products.index');
Route::get('/auth/google',[GoogleController::class,'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback',[GoogleController::class,'handleGoogleCallback'])->name('auth.google.callback');

// Chuyển hướng về trang chính với các route chưa định nghĩa
Route::fallback(function () {
    return redirect('/products');
});
