<?php

use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\FileController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CheckoutController;


use Illuminate\Support\Facades\Route;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthenticationController::class, 'userInfo']);
    Route::post('logout', [AuthenticationController::class, 'logOut'])->middleware('auth:sanctum');

    // Posts - accessible by all authenticated users (index, show)
    Route::get('posts', [PostController::class, 'index']);
    Route::get('posts/{post}', [PostController::class, 'show']);

    // Posts - create (seller, admin)
    Route::post('posts', [PostController::class, 'store'])->middleware('role:seller,admin');

    // Posts - update (seller, admin)
    Route::put('posts/{post}', [PostController::class, 'update'])->middleware('role:seller,admin');
    Route::patch('posts/{post}', [PostController::class, 'update'])->middleware('role:seller,admin');

    // Posts - delete (admin only)
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->middleware('role:admin');

    Route::get('sellers', [PostController::class, 'index'])->middleware('role:admin'); 
    Route::post('sellers/{post}/approve', [PostController::class, 'approve'])->middleware('role:admin'); 
    Route::post('sellers/{post}/disapprove', [PostController::class, 'disapprove'])->middleware('role:admin'); 
    
     Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);
    Route::post('categories', [CategoryController::class, 'store'])->middleware('role:admin');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->middleware('role:admin');
    Route::patch('categories/{category}', [CategoryController::class, 'update'])->middleware('role:admin');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->middleware('role:admin');

    Route::get('/seller/products', [ProductController::class, 'myProducts'])->middleware('role:seller');
    Route::post('/products', [ProductController::class, 'store'])->middleware('role:seller');
    Route::put('/products/{product}', [ProductController::class, 'update'])->middleware('role:seller');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->middleware('role:admin');

 Route::post('/products/{product}/approve', [ProductController::class, 'approveProduct'])->middleware('role:admin');
Route::post('/products/{product}/disapprove', [ProductController::class, 'disapproveProduct'])->middleware('role:admin');
Route::get('/products/approved', [ProductController::class, 'AllApprovedProducts'])->middleware('role:admin');
Route::get('/products/disapproved', [ProductController::class, 'AllDisapprovedProducts'])->middleware('role:admin');

    Route::get('cart', [CartController::class, 'cart']);
    Route::post('cart/add', [CartController::class, 'addToCart']);
    Route::patch('cart/update/{id}', [CartController::class, 'updateQty']);
    Route::delete('cart/remove/{id}', [CartController::class, 'removeItem']);


Route::post('checkout', [CheckoutController::class, 'checkout'])->middleware('auth:sanctum');
Route::get('user/orders', [CheckoutController::class, 'myOrders'])->middleware('auth:sanctum');
});
