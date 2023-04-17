<?php

namespace Modules\Profile\Providers;

use Modules\Shared\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(): void
    {
        self::$moduleName = 'profile';
        self::loadVersionAwareRoutes('api');
        self::loadVersionAwareRoutes('web');
    }
}
