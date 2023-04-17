<?php

namespace Modules\Profile\Providers;

use Modules\Shared\Providers\SharedServiceProvider as ServiceProvider;

final class ProfileServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected string $moduleName = 'Profile';

    /**
     * @var string $moduleNameLower
     */
    protected string $moduleNameLower = 'profile';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
