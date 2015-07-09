<?php namespace Arcanedev\Head\Laravel;

use Arcanedev\Head\Head;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * Class ServiceProvider
 * @package Arcanedev\Head\Laravel
 */
class ServiceProvider extends IlluminateServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $basePath  = __DIR__ . '/../..';

        $this->publishes([
            $basePath . '/config/config.php' => config_path('head.php'),
        ]);

        $this->mergeConfigFrom(
            $basePath . '/config/config.php', 'head'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerServices();
        $this->registerFacades();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'arcanedev.head'
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    private function registerServices()
    {
        $this->app->singleton('arcanedev.head', function($app) {
            /** @var \Illuminate\Config\Repository $config */
            $config  = $app['config'];

            return new Head($config->get('head'));
        });
    }

    private function registerFacades()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Head', Facade::class);
    }
}
