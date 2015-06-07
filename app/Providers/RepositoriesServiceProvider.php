<?php namespace Owl\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \App::bind('Owl\Repositories\CommentRepositoryInterface', 'Owl\Repositories\Eloquent\CommentRepository');
        \App::bind('Owl\Repositories\ImageRepositoryInterface', 'Owl\Repositories\Eloquent\ImageRepository');
    }
}
