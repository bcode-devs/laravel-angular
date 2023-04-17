<?php

namespace Modules\Auth\Exceptions;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Exception;

final class JwtFailedException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param Request $request
     * @return Response
     */
    public function render(Request $request): Response
    {
        return response([
            'message' => 'User is not authorized',
            'errors' => [$this->getMessage()],
            'type' => class_basename($this),
        ], ResponseAlias::HTTP_UNAUTHORIZED);
    }
}
