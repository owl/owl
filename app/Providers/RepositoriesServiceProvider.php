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
        \App::bind('Owl\Repositories\LoginTokenRepositoryInterface', 'Owl\Repositories\Eloquent\LoginTokenRepository');
        \App::bind('Owl\Repositories\LikeRepositoryInterface', 'Owl\Repositories\Eloquent\LikeRepository');
        \App::bind('Owl\Repositories\StockRepositoryInterface', 'Owl\Repositories\Eloquent\StockRepository');
        \App::bind('Owl\Repositories\TemplateRepositoryInterface', 'Owl\Repositories\Eloquent\TemplateRepository');
        \App::bind('Owl\Repositories\UserRepositoryInterface', 'Owl\Repositories\Eloquent\UserRepository');
    }
}
