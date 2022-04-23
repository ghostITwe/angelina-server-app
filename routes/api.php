<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\UserController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/auth', [AuthController::class, 'auth'])->name('login');
Route::post('/registration', [AuthController::class, 'registration']);

Route::get('/categories', [CategoryController::class, 'getCategoryList']);
Route::get('/categories/{title}', [CategoryController::class, 'getCategory']);

Route::get('/products/{id}', [ProductController::class, 'getProduct']);
Route::get('/products', [ProductController::class, 'getProducts']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('/profile', [UserController::class, 'getUser']);
//    Route::get('/profile/history', [UserController::class, 'getUser']);

    Route::post('/categories/create', [CategoryController::class, 'createCategory']);
    Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategory']);

    Route::post('/products/create', [ProductController::class, 'createProduct']);
    Route::delete('/products/{id}', [ProductController::class, 'deleteProduct']);
});
