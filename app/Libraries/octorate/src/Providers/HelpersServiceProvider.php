<?php

namespace Octorate\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class HelpersServiceProvider
 * @package Octorate\Providers
 */
class HelpersServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {

    }

    /**
     *
     */
    public function register()
    {
        foreach (glob(__DIR__ . '/../Helpers/*.php') as $filename) {
            require_once($filename);
        }
    }
}
