<?php

namespace Secom\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class SecomServiceProvider
 * @package Secom\Providers
 */
class SecomServiceProvider extends ServiceProvider
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