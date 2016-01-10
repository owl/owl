<?php namespace Owl\Providers;

/**
 * @copyright (c) owl
 */

use Illuminate\Support\ServiceProvider;
//use Owl\Presenter\ViewComposers as VC;

/**
 * Class ViewComposerServiceProvider
 *
 * @package Owl\Providers
 */
class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composers([
            'Owl\Presenter\ViewComposers\MailNotifySettingComposer' => ['user.edit'],
        ]);
    }

    public function register()
    {
    }
}
