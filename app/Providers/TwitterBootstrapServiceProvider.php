<?php namespace Owl\Providers;

use Illuminate\Support\ServiceProvider;

class TwitterBootstrapServiceProvider extends ServiceProvider {

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
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../vendor/twitter/bootstrap/dist' => public_path('/packages/bootstrap'),
        ]); 
    }
}
