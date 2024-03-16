<?php

namespace App\Providers;

use App\Repository\AuthRepositoryInterface;
use App\Repository\BrandRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\Eloquent\AuthRepository;
use App\Repository\Eloquent\BrandRepository;
use App\Repository\Eloquent\CategoryRepository;
use App\Repository\Eloquent\ProductFeatureDetailRepository;
use App\Repository\Eloquent\ProductFeatureItemDetailRepository;
use App\Repository\Eloquent\ProductFeatureItemRepository;
use App\Repository\Eloquent\ProductFeatureRepository;
use App\Repository\Eloquent\Repository;
use App\Repository\Eloquent\SubCategoryRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Eloquent\ProductRepository;
use App\Repository\Eloquent\ProductImageRepository;
use App\Repository\Eloquent\OrderRepository;
use App\Repository\Eloquent\OrderDetailRepository;
use App\Repository\Eloquent\CartRepository;
use App\Repository\CartRepositoryInterface;
use App\Repository\OrderDetailRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\ProductFeatureDetailRepositoryInterface;
use App\Repository\ProductFeatureItemDetailRepositoryInterface;
use App\Repository\ProductFeatureItemRepositoryInterface;
use App\Repository\ProductFeatureRepositoryInterface;
use App\Repository\ProductImageRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use App\Repository\RepositoryInterface;
use App\Repository\SubCategoryRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RepositoryInterface::class, Repository::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->singleton(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->singleton(SubCategoryRepositoryInterface::class, SubCategoryRepository::class);
        $this->app->singleton(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->singleton(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->singleton(ProductImageRepositoryInterface::class, ProductImageRepository::class);
        $this->app->singleton(ProductFeatureRepositoryInterface::class, ProductFeatureRepository::class);
        $this->app->singleton(ProductFeatureDetailRepositoryInterface::class, ProductFeatureDetailRepository::class);
        $this->app->singleton(ProductFeatureItemRepositoryInterface::class, ProductFeatureItemRepository::class);
        $this->app->singleton(ProductFeatureItemDetailRepositoryInterface::class, ProductFeatureItemDetailRepository::class);
        $this->app->singleton(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->singleton(OrderDetailRepositoryInterface::class, OrderDetailRepository::class);
        $this->app->singleton(CartRepositoryInterface::class, CartRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
