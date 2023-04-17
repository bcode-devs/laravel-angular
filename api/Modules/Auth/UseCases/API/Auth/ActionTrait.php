<?php

namespace Modules\Auth\UseCases\API\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Modules\Profile\Http\Resources\ProfileResource;
use Modules\Shared\Entities\User\User;
use Symfony\Component\HttpFoundation\Response;

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
        //$this->guard()->logout();
        $request->user()->tokens()->delete();
        //$request->user()->currentAccessToken()->delete();
        //$request->session()->invalidate();
        //$request->session()->regenerateToken();
    }
}
