<?php

use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\PostController;
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
});
