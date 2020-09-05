<?php

namespace Api\Providers;

use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Class ApiAuthServiceProvider
 * @package Api\Providers
 */
class ApiAuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerAuthorizations();
        $this->registerPassportConfigs();
    }

    /**
     * @return void
     */
    public function registerAuthorizations()
    {

    }

    /**
     * @return void
     */
    public function registerPassportConfigs()
    {
        Passport::tokensExpireIn(now()->addSeconds(config('api.auth.expire')));
        Passport::refreshTokensExpireIn(now()->addSeconds(config('api.auth.rememberExpire')));
    }
}
