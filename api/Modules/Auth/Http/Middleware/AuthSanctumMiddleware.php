<?php

namespace Modules\Auth\Http\Middleware;

use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

final class AuthSanctumMiddleware extends EnsureFrontendRequestsAreStateful
{

}
