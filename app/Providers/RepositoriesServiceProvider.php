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
        // Eloquent
        \App::bind('Owl\Repositories\LikeRepositoryInterface', 'Owl\Repositories\Eloquent\LikeRepository');
        \App::bind('Owl\Repositories\StockRepositoryInterface', 'Owl\Repositories\Eloquent\StockRepository');
        \App::bind('Owl\Repositories\TemplateRepositoryInterface', 'Owl\Repositories\Eloquent\TemplateRepository');
        \App::bind('Owl\Repositories\UserRepositoryInterface', 'Owl\Repositories\Eloquent\UserRepository');
        \App::bind('Owl\Repositories\TagRepositoryInterface', 'Owl\Repositories\Eloquent\TagRepository');
        \App::bind('Owl\Repositories\TagFtsRepositoryInterface', 'Owl\Repositories\Eloquent\TagFtsRepository');
        \App::bind('Owl\Repositories\ItemRepositoryInterface', 'Owl\Repositories\Eloquent\ItemRepository');
        \App::bind('Owl\Repositories\ItemFtsRepositoryInterface', 'Owl\Repositories\Eloquent\ItemFtsRepository');
        \App::bind('Owl\Repositories\ItemHistoryRepositoryInterface', 'Owl\Repositories\Eloquent\ItemHistoryRepository');
        \App::bind('Owl\Repositories\UserRoleRepositoryInterface', 'Owl\Repositories\Eloquent\UserRoleRepository');

        // Fluent(Query Builder)
        \App::bind('Owl\Repositories\CommentRepositoryInterface', 'Owl\Repositories\Fluent\CommentRepository');
        \App::bind('Owl\Repositories\ImageRepositoryInterface', 'Owl\Repositories\Fluent\ImageRepository');
        \App::bind('Owl\Repositories\LoginTokenRepositoryInterface', 'Owl\Repositories\Fluent\LoginTokenRepository');
        \App::bind('Owl\Repositories\ReminderTokenRepositoryInterface', 'Owl\Repositories\Fluent\ReminderTokenRepository');
    }
}
