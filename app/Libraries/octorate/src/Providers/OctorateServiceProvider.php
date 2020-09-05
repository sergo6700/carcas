<?php

namespace Octorate\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class OctorateServiceProvider
 * @package Octorate\Providers
 */
class OctorateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfigs();
    }

    /**
     *
     */
    public function register()
    {
        $this->registerProviders();
    }

    /**
     *
     */
    public function registerProviders()
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(HelpersServiceProvider::class);
    }

    /**
     *
     */
    public function publishConfigs()
    {
        $this->publishes([
            __DIR__.'../../config/secom.php' => config_path('secom.php'),
        ]);
    }
}
