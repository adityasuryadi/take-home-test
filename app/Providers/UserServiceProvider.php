<?php

namespace App\Providers;

use App\Services\UserService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use App\Services\Impl\UserServiceImpl;

class UserServiceProvider extends ServiceProvider implements DeferrableProvider
{
     /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public array $singletons = [
        UserService::class => UserServiceImpl::class
    ];
    public function provides():array{
        return [UserService::class];
    }
}
