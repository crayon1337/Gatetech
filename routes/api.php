<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'user'], function() {
   Route::post('register', [\App\Http\Controllers\UserController::class, 'register']);
   Route::post('login', [\App\Http\Controllers\UserController::class, 'login'])->name('login');
});

Route::group(['prefix' => 'category'], function() {
    Route::get('/', [\App\Http\Controllers\CategoryController::class, 'index']);
    Route::get('{slug}', [\App\Http\Controllers\CategoryController::class, 'show']);

    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::post('/', [\App\Http\Controllers\CategoryController::class, 'create']);
        Route::patch('{slug}', [\App\Http\Controllers\CategoryController::class, 'update']);
        Route::delete('{slug}', [\App\Http\Controllers\CategoryController::class, 'delete']);
    });
});

Route::group(['prefix' => 'post'], function() {
    Route::get('/', [\App\Http\Controllers\PostController::class, 'index']);
    Route::get('{slug}', [\App\Http\Controllers\PostController::class, 'show']);

    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::post('/', [\App\Http\Controllers\PostController::class, 'create']);
        Route::patch('{slug}', [\App\Http\Controllers\PostController::class, 'update']);
        Route::delete('{slug}', [\App\Http\Controllers\PostController::class, 'delete']);
    });
});
