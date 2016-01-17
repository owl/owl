<?php namespace Owl\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composers([
            'Owl\Http\ViewComposers\UserComposer'              => '*',
            'Owl\Http\ViewComposers\MailNotifySettingComposer' => ['user.edit'],
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
