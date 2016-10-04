<?php namespace Owl\Providers;

/**
 * @copyright (c) owl
 */

use Illuminate\Support\ServiceProvider;

/**
 * Class DevelopServiceProvider
 */
class DevelopServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $providers = [
        'Barryvdh\Debugbar\ServiceProvider',
    ];

    /**
     * @var array
     */
    protected $facadeAliases = [
        'Debugbar' => 'Barryvdh\Debugbar\Facade',
    ];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->registerServiceProviders();
            $this->registerFacadeAliases();
        }
    }

    /**
     * register service providers
     */
    protected function registerServiceProviders()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * add class aliases
     */
    protected function registerFacadeAliases()
    {
        $loader = AliasLoader::getInstance();
        foreach ($this->facadeAliases as $alias => $facade) {
            $loader->alias($alias, $facade);
        }
    }
}
