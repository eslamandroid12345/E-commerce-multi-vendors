<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Site\Order\OrderController;
use App\Http\Controllers\Api\V1\Site\Cart\CartController;

Route::group(['prefix' => 'auth', 'controller' => AuthController::class], function () {
    Route::group(['prefix' => 'sign'], function () {
        Route::post('in', 'signIn');
        Route::post('up', 'signUp');
        Route::post('out', 'signOut');
    });
    Route::get('what-is-my-platform', 'whatIsMyPlatform'); // returns 'platform: website!
});

Route::group(['controller' => CartController::class], function () {
    Route::group(['prefix' => 'cart'], function () {
        Route::post('add', 'addToCart');
        Route::post('update/{id}', 'updateItemCart');
        Route::post('delete/{id}', 'deleteFromCart');
        Route::post('deleteAll', 'deleteAllFromCart');
        Route::get('getAllItems', 'getAllItems');
    });
});

Route::post('order/create',[OrderController::class,'orderCreate']);
