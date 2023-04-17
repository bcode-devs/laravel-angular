<?php

namespace Modules\Shared\Http\Middleware;

use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Http\Request;

final class SharedThrottle extends ThrottleRequests
{
    /**
     * Create a 'too many attempts' exception.
     *
     * @param Request $request
     * @param string $key
     * @param int $maxAttempts
     * @param callable|null $responseCallback
     * @return HttpResponseException|ThrottleRequestsException
     */
    protected function buildException($request, $key, $maxAttempts, $responseCallback = null): HttpResponseException|ThrottleRequestsException
    {
        $retryAfter = $this->getTimeUntilNextRetry($key);

        $headers = $this->getHeaders(
            $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter),
            $retryAfter
        );

        return is_callable($responseCallback)
            ? new HttpResponseException($responseCallback($request, $headers))
            : new ThrottleRequestsException(__('shared::validation.throttle_error'), null, $headers);
    }
}
