<?php
namespace App\Providers;

use App\Repositories\CacheRepoInterface;
use App\Repositories\PersistentRepoInterface;
use App\Repositories\PostgreRepo;
use App\Repositories\RandomUserRepo;
use App\Repositories\RedisRepo;
use App\Repositories\SourceRepoInterface;
use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    public $bindings = [
        SourceRepoInterface::class => RandomUserRepo::class,
        CacheRepoInterface::class => RedisRepo::class,
        PersistentRepoInterface::class => PostgreRepo::class,
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