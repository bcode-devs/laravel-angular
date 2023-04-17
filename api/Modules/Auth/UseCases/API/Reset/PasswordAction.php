<?php

namespace Modules\Auth\UseCases\API\Reset;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Modules\Shared\Entities\User\User;
use Modules\Auth\Entities\User\Reset;
use Illuminate\Http\Response;

final class PasswordAction
{
    public function __invoke(array $request): Response
    {
        // find reset token
        $passwordReset = Reset::query()->where('token', $request['token'])->first();
        // check if it does not expire: the time is one hour
        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete();
            return response(['message' => trans('auth::passwords.code_is_expire')], ResponseAlias::HTTP_UNAUTHORIZED);
        }
        // find user's email
        $user = User::query()->firstWhere('email', $passwordReset->email);
        // update user password
        $user->update(['password' => bcrypt($request['password'])]);
        // delete current reset token
        $passwordReset->delete();
        return response(['message' => __('password has been successfully reset')], ResponseAlias::HTTP_OK);
    }
}
