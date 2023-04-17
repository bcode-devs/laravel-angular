<?php

namespace Modules\Auth\Exceptions;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Exception;

final class EmailTakenException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  Request  $request
     * @return Response
     */
    public function render(Request $request): Response
    {
        return response()->view('auth::oauth.email.taken', [], 400);
    }
}
