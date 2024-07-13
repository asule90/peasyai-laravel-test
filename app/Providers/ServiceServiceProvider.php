<?php
namespace App\Providers;

use App\Services\SiteService;
use App\Services\SiteServiceInterface;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    public $bindings = [
        SiteServiceInterface::class => SiteService::class
    ];
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
    }
}