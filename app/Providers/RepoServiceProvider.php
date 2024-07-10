<?php
namespace App\Providers;

use App\Repositories\DataRepository;
use App\Repositories\DataRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    public $bindings = [
        DataRepositoryInterface::class => DataRepository::class
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