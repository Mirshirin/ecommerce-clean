<?php

namespace App\Providers;
use App\Models\Role;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CategoryRepository;
use App\Contracts\RoleRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Repositories\PermissionRepository;
use App\Contracts\OrderRepositoryInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\PermissionRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);        
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class, function ($app) {
            return new RoleRepository(new Role());
        });


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
