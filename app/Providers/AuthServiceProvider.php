<?php namespace Owl\Providers;

/**
 * @copyright (c) owl
 */

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Guard;

/**
 * Class AuthServiceProvider
 * 認証周りのインスタンス管理プロバイダー
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerAuthDrivers();
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * カスタムAuth Driverをサービスコンテナに登録
     */
    protected function registerAuthDrivers()
    {
        $this->app['auth']->extend('owl', function ($app) {
            return new Guard(
                $app->make('\Owl\Authenticate\Driver\OwlUserProvider'),
                $app['session.store']
            );
        });
    }
}
