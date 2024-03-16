<?php


use App\Http\Controllers\Api\V1\Dashboard\Admin\Auth\AuthController;
use App\Http\Controllers\Api\V1\Dashboard\Admin\Category\CategoryController;
use App\Http\Controllers\Api\V1\Dashboard\Admin\SubCategory\SubCategoryController;
use App\Http\Controllers\Api\V1\Dashboard\Admin\User\UserController;
use App\Http\Controllers\Api\V1\Dashboard\Product\FeatureProductController;
use App\Http\Controllers\Api\V1\Dashboard\Product\ProductFeatureItemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Dashboard\Admin\Brand\BrandController;
use App\Http\Controllers\Api\V1\Dashboard\Admin\Seller\SellerDashboardController;
use App\Http\Controllers\Api\V1\Dashboard\Product\ProductController;
use App\Http\Controllers\Api\V1\Dashboard\Seller\SellerController;
use App\Http\Controllers\Api\V1\Dashboard\Order\OrderController;

Route::group(['prefix' => 'admin', 'controller' => AuthController::class,'middleware' => 'auth:admin-api'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::get('get-profile', 'getProfile');
        Route::post('logout', 'logout');
    });
});

Route::group(['prefix' => 'admin', 'controller' => AuthController::class], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'login');
    });
});

Route::post('register/seller', [SellerController::class,'register']);
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin-api'], function () {
        Route::apiResource('categories',CategoryController::class);
        Route::post('categories/change-status/{id}',[CategoryController::class,'changeStatus']);
        Route::apiResource('sub_categories',SubCategoryController::class);
        Route::post('sub_categories/change-status/{id}',[SubCategoryController::class,'changeStatus']);
        Route::apiResource('brands', BrandController::class);
        Route::post('brands/change-status/{id}',[BrandController::class,'changeStatus']);
        Route::apiResource('products', ProductController::class);
        Route::post('products/change-status/{id}',[ProductController::class,'changeStatus']);
        Route::get('product/sellers',[ProductController::class,'sellers']);
        Route::post('add-feature/{id}', [FeatureProductController::class,'addFeature']);
        Route::get('get-all-prices/{id}', [ProductFeatureItemController::class,'getAllPrices']);
        Route::post('update-prices/{id}', [ProductFeatureItemController::class,'updateAllPrices']);
        Route::apiResource('sellers', SellerDashboardController::class);
        Route::post('seller/change-status/{id}', [SellerDashboardController::class,'changeStatus']);
        Route::get('orders', [OrderController::class,'getAllOrders']);
        Route::get('getOneOrder/{id}', [OrderController::class,'getOneOrder']);
        Route::post('orders/filter', [OrderController::class,'filterOrder']);
        Route::apiResource('customers', UserController::class)->except('store','update');
        Route::post('customers/change-status/{id}',[UserController::class,'changeStatus']);
        Route::post('orders/change-status/{id}',[OrderController::class,'changeStatus']);
        Route::get('get-all-features/{id}', [FeatureProductController::class,'getAllFeatures']);
        Route::post('update-features/{id}', [FeatureProductController::class,'updateFeatures']);
        Route::delete('delete-feature/{id}', [FeatureProductController::class,'deleteFeature']);
});


