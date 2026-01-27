<?php


use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\FileController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\AdminAuthController;


use Illuminate\Support\Facades\Route;



Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});
    
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('sellers', SellerController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('products', ProductController::class);

        Route::post('sellers/{seller}/approve', [SellerController::class, 'approve'])
            ->name('sellers.approve');
        Route::post('sellers/{seller}/reject', [SellerController::class, 'reject'])
            ->name('sellers.reject');
        
        Route::post('products/{product}/status', [ProductController::class, 'updateStatus'])
            ->name('products.updateStatus');
    });