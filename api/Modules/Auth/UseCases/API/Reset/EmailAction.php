<?php

namespace Modules\Auth\UseCases\API\Reset;

use Modules\Auth\Mail\AuthResetPasswordMail;
use Modules\Auth\Entities\User\Reset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

final class EmailAction
{
    public function __invoke(array $request): Response
    {
        // Delete all old code that user send before.
        Reset::query()->where('email', $request['email'])->delete();

        $request['token'] = Str::uuid();

        // Create a new code
        $reset = Reset::query()->create($request);

        // Send email to user
        Mail::to($reset['email'])->send(new AuthResetPasswordMail($reset['token']));

        return response(['message' => trans('passwords.sent')], 200);
    }
}
