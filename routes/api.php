<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ObjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/auth', [AuthController::class, 'auth'])->name('login');
Route::post('/registration', [AuthController::class, 'registration']);

Route::get('/objects', [ObjectController::class, 'getObjects']);
Route::get('/objects/{id}', [ObjectController::class, 'getObject']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
