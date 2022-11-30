<?php

namespace App\Providers;

use App\Http\Resources\BaseResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\LoginResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        BaseResource::withoutWrapping();
        UserResource::withoutWrapping();
        LoginResource::withoutWrapping();
        ProfileResource::withoutWrapping();
        PostResource::withoutWrapping();
        CommentResource::withoutWrapping();
        CategoryResource::withoutWrapping();
    }
}
