<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\Contracts\PermissionRepositoryInterface;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;



class AuthServiceProvider extends ServiceProvider
{
    //protected $permissionRepository;
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    // public function __construct(PermissionRepositoryInterface $permissionRepository )
    // {
    //      $this->permissionRepository = $permissionRepository;
    // }
    
    public function boot()
    {
        Gate::before(function ($user, $ability) {
            return ($user->hasRole('Admin') || $user->hasRole('Super Admin') ) ? true : null;
        });
        
        Paginator::useBootstrapFive();
      
        
    }

    
}
