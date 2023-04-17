<?php

namespace Modules\Auth\Http\Controllers\API;

use Modules\Auth\UseCases\API\OAuth\HandleProviderCallbackAction;
use Modules\Auth\UseCases\API\OAuth\RedirectToProviderAction;
use Illuminate\Routing\Controller;

final class OAuthController extends Controller
{
    public function handleProviderCallback(string $network, HandleProviderCallbackAction $action): mixed
    {
        return $action($network);
    }

    public function redirectToProvider(string $provider, RedirectToProviderAction $action): mixed
    {
        return $action($provider);
    }
}
