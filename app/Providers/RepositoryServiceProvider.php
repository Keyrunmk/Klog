<?php

namespace App\Providers;

use App\Contracts\CategoryContract;
use App\Contracts\PostContract;
use App\Contracts\ProfileContract;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Repositories\ProfileRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public $bindings = [
        ProfileContract::class => ProfileRepository::class,
        PostContract::class => PostRepository::class,
        CategoryContract::class => CategoryRepository::class,
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // foreach ($this->repositories as $interface => $repository) {
        //     $this->app->bind($interface, $repository);
        // }
    }

    public function provides()
    {
        return array_keys($this->bindings);
    }
}
