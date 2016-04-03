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
        // Fluent(Query Builder)
        \App::bind('Owl\Repositories\CommentRepositoryInterface', 'Owl\Repositories\Fluent\CommentRepository');
        \App::bind('Owl\Repositories\ImageRepositoryInterface', 'Owl\Repositories\Fluent\ImageRepository');
        \App::bind('Owl\Repositories\LoginTokenRepositoryInterface', 'Owl\Repositories\Fluent\LoginTokenRepository');
        \App::bind('Owl\Repositories\LikeRepositoryInterface', 'Owl\Repositories\Fluent\LikeRepository');
        \App::bind('Owl\Repositories\StockRepositoryInterface', 'Owl\Repositories\Fluent\StockRepository');
        \App::bind('Owl\Repositories\TemplateRepositoryInterface', 'Owl\Repositories\Fluent\TemplateRepository');
        \App::bind('Owl\Repositories\TagRepositoryInterface', 'Owl\Repositories\Fluent\TagRepository');
        \App::bind('Owl\Repositories\TagFtsRepositoryInterface', 'Owl\Repositories\Fluent\TagFtsRepository');
        \App::bind('Owl\Repositories\ItemRepositoryInterface', 'Owl\Repositories\Fluent\ItemRepository');
        \App::bind('Owl\Repositories\ItemFtsRepositoryInterface', 'Owl\Repositories\Fluent\ItemFtsRepository');
        \App::bind('Owl\Repositories\ItemHistoryRepositoryInterface', 'Owl\Repositories\Fluent\ItemHistoryRepository');
        \App::bind('Owl\Repositories\UserRepositoryInterface', 'Owl\Repositories\Fluent\UserRepository');
        \App::bind('Owl\Repositories\UserRoleRepositoryInterface', 'Owl\Repositories\Fluent\UserRoleRepository');
        \App::bind(
            'Owl\Repositories\ReminderTokenRepositoryInterface',
            'Owl\Repositories\Fluent\ReminderTokenRepository'
        );
        \App::bind(
            'Owl\Repositories\UserMailNotificationRepositoryInterface',
            'Owl\Repositories\Fluent\UserMailNotificationRepository'
        );
    }
}
