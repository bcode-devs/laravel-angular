<?php

namespace Modules\Horizon\Providers;

use Laravel\Horizon\HorizonApplicationServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;

final class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    protected function authorization()
    {
        Horizon::auth(function () {
            return true;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        // Horizon::routeSmsNotificationsTo('15556667777');
        // Horizon::routeMailNotificationsTo('example@example.com');
        // Horizon::routeSlackNotificationsTo('slack-webhook-url', '#channel');

        // Horizon::night();
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewHorizon', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }
}
