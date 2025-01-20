<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\impl\AuthServiceImpl;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
        AuthService::class => AuthServiceImpl::class
    ];
    public function provides():array{
        return [AuthService::class];
    }
}
