<?php

namespace Modules\Auth\Http\Controllers\API;

use Modules\Auth\Http\Requests\Reset\PasswordRequest;
use Modules\Auth\UseCases\API\Reset\PasswordAction;
use Modules\Auth\Http\Requests\Reset\EmailRequest;
use Modules\Auth\UseCases\API\Reset\EmailAction;
use Illuminate\Http\Response;

final class ResetController
{
    public function email(EmailRequest $request, EmailAction $action): Response
    {
        return $action($request->validated());
    }

    public function password(PasswordRequest $request, PasswordAction $action): Response
    {
        return $action($request->validated());
    }
}
