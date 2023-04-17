<?php

namespace Modules\Telescope\Providers;

use Laravel\Telescope\TelescopeApplicationServiceProvider;
use Laravel\Telescope\IncomingEntry;
use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\Telescope;

final class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected string $moduleName = 'Telescope';

    /**
     * @var string $moduleNameLower
     */
    protected string $moduleNameLower = 'telescope';

    /**
     * Register any application services.
     */
    public function register(): void
    {

        // Telescope::night();

        $this->hideSensitiveRequestDetails();

        Telescope::filter(function (IncomingEntry $entry) {
            if ($this->app->environment('local')) {
                return true;
            }

            return $entry->isReportableException() ||
                $entry->isFailedRequest() ||
                $entry->isFailedJob() ||
                $entry->isScheduledTask() ||
                $entry->hasMonitoredTag();
        });
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     */
    protected function hideSensitiveRequestDetails(): void
    {
        if ($this->app->environment('local')) {
            return;
        }

        Telescope::hideRequestParameters(['_token']);

        Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
        ]);
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewTelescope', function ($user) {
            return true;
        });
    }
}
