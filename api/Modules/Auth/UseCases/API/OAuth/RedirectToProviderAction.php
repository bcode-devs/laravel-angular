<?php

namespace Modules\Auth\UseCases\API\OAuth;

use Laravel\Socialite\Facades\Socialite;

final class RedirectToProviderAction
{
    public function __invoke(string $provider): array
    {

        return [
            'url' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl(),
        ];
    }
}
