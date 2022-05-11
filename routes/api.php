<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['checkDatabase']], function () {

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
        Route::post('/categories/create', [CategoryController::class, 'createCategory'])->middleware('admin');

        Route::group(['middleware' => ['admin']], function () {
//            Route::post('/categories/create', [CategoryController::class, 'createCategory']);
            Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategory']);

            Route::post('/products/create', [ProductController::class, 'createProduct']);
            Route::delete('/products/{id}', [ProductController::class, 'deleteProduct']);
        });

        Route::get('/orders', [OrderController::class, 'getOrderList']);
//    Route::get('/orders/{id}',[OrderController::class,'getOrder']);

//    Route::post('/orders/create',[OrderController::class,'craeteOrder']);
//    Route::delete('/orders/{id}',[OrderController::class,'deleteOrder']);
//
        Route::group(['prefix' => 'cart'], function () {
            Route::get('/', [CartController::class, 'getCart']);
            Route::post('/add/{id}', [CartController::class, 'addItem']);
            Route::post('confirm', [CartController::class, 'cartConfirm']);
        });
//    Route::post('/cart/delete',[CartController::class,'deleteProduct']);
    });
});
