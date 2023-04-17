<?php

namespace Modules\Auth\Http\Middleware;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Modules\Auth\Exceptions\JwtFailedException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Closure;
use Auth;

final class AuthJwtTokenMiddleware
{
    use AuthenticatesUsers;

    public function handle(Request $request, Closure $next): mixed
    {
   /*     $token = $request->bearerToken();
        if (!$token) {
            $token = $request->input('api-token');
        }
        if (!$token) {
            throw new JwtFailedException('tymon.jwt.absent');
        }
        try {
            Auth::guard()->setToken($token);
            $user = Auth::guard('api')->user();
        } catch (TokenExpiredException $e) {
            throw new JwtFailedException('tymon.jwt.expired');
        } catch (JWTException $e) {
            throw new JwtFailedException('tymon.jwt.invalid');
        }

        if (!$user) {
            throw new JwtFailedException('tymon.jwt.user_not_found');
        }*/

        // $this->events->dispatch('tymon.jwt.valid', $user);
        return $next($request);
    }
}
