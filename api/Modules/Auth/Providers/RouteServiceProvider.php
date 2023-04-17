<?php

namespace Modules\Auth\Providers;

use Modules\Shared\Providers\RouteServiceProvider as ServiceProvider;
use Modules\Auth\Http\Middleware\AuthSanctumMiddleware;

final class RouteServiceProvider extends ServiceProvider
{

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(): void
    {
        self::$moduleName = 'auth';
        self::loadVersionAwareRoutes('api');
        self::loadVersionAwareRoutes('web');
        app('router')->aliasMiddleware('auth.sanctum', AuthSanctumMiddleware::class);
    }
}
