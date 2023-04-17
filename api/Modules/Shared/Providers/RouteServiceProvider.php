<?php

namespace Modules\Shared\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Middleware\HandleCors;
use Modules\Shared\Http\Middleware\SharedDatabaseLog;
use Modules\Shared\Http\Middleware\SharedThrottle;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Webmozart\Assert\Assert;

class RouteServiceProvider extends ServiceProvider
{
    public static string $moduleName = 'shared';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(): void
    {
        self::loadVersionAwareRoutes('web');
        self::loadVersionAwareRoutes('api');
        app('router')->aliasMiddleware('shared.throttle', SharedThrottle::class);
        app('router')->aliasMiddleware('shared.handle.cors', HandleCors::class);
        app('router')->aliasMiddleware('shared.db.log', SharedDatabaseLog::class);
    }

    public static function loadVersionAwareRoutes(string $type): void
    {
        Assert::oneOf($type, ['api','web']);
        Route::group([], module_path(self::$moduleName, sprintf('Routes/%s.base.php', $type)));
        $apiVersion = self::getApiVersion();
        $routeFile = $apiVersion ?
            module_path(self::$moduleName, sprintf('Routes/%s.%s.php', $type, $apiVersion)) : null;
        if ($routeFile && file_exists($routeFile)) {
            Route::group([], $routeFile);
        }
    }

    private static function getApiVersion(): ?string
    {
        // In the test environment, the route service provider is loaded _before_ the request is made,
        // so we can't rely on the header.
        // Instead, we manually set the API version as an env variable in applicable test cases.
        $version = app()->runningUnitTests() ? env('X_API_VERSION') : request()->header('X-Api-Version');

        if ($version) {
            Assert::oneOf($version, ['v1']);
        }

        return $version;
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
