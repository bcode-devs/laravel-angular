<?php

namespace Modules\Auth\UseCases\API\Reset;

use Modules\Shared\Entities\User\User;
use Modules\Auth\Entities\User\Reset;
use Illuminate\Http\Response;

final class PasswordAction
{
    public function __invoke(array $request): Response
    {
        // find the code
        $passwordReset = Reset::query()->where('token', $request['token'])->first();

        // check if it does not expire: the time is one hour
        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete();
            return response(['message' => trans('passwords.code_is_expire')], 422);
        }

        // find user's email
        $user = User::query()->firstWhere('email', $passwordReset->email);
        // update user password
        $user->update(['password' => bcrypt($request['password'])]);

        // delete current code
        $passwordReset->delete();

        return response(['message' => 'password has been successfully reset'], 200);
    }
}
