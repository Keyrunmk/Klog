<?php

namespace App\Providers;

use App\Contracts\AdminContract;
use App\Contracts\CategoryContract;
use App\Contracts\CommentContract;
use App\Contracts\PostContract;
use App\Contracts\PostReport;
use App\Contracts\TagContract;
use App\Contracts\UserContract;
use App\Repositories\AdminRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\PostReportRepository;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public $repositories = [
        AdminContract::class => AdminRepository::class,
        UserContract::class => UserRepository::class,
        ProfileContract::class => ProfileRepository::class,
        PostContract::class => PostRepository::class,
        TagContract::class => TagRepository::class,
        CategoryContract::class => CategoryRepository::class,
        PostReport::class => PostReportRepository::class,
        CommentContract::class => CommentRepository::class,
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
        foreach ($this->repositories as $interface => $repository) {
            $this->app->bind($interface, $repository);
        }
    }
}
