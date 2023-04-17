<?php

namespace Modules\Auth\UseCases\API\Auth;

use Modules\Profile\Http\Resources\ProfileResource;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Symfony\Component\HttpFoundation\Response;
use Modules\Shared\Entities\User\User;
use Illuminate\Http\Request;

trait ActionTrait
{
    use AuthenticatesUsers;

    protected function authenticated(Request $request): Response
    {
        $token = $request->user()->createToken(config('app.name'))->plainTextToken;
        return (new ProfileResource($request->user()))
            ->additional(['token' => $token])
            ->response()
            ->header('Api-Token', $token);
    }

    public function register(array $request): void
    {
        User::register(
            $request['name'],
            $request['email'],
            $request['password']
        );
    }

    public function logout(Request $request): void
    {
        $request->user()->tokens()->delete();
    }
}
