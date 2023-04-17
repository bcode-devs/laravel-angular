<?php

namespace Modules\Auth\Http\Controllers\API;

use Modules\Auth\Http\Requests\Auth\VerifyEmailRequest;
use Modules\Auth\UseCases\API\Auth\VerifyEmailAction;
use Modules\Auth\Http\Requests\Auth\SignInRequest;
use Modules\Auth\Http\Requests\Auth\SignUpRequest;
use Modules\Auth\UseCases\API\Auth\SignUpAction;
use Modules\Auth\UseCases\API\Auth\SignInAction;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;

final class AuthController extends Controller
{

    public function signUp(SignUpRequest $request, SignUpAction $action): JsonResponse
    {
        return $action($request->validated());
    }

    public function signIn(SignInRequest $request, SignInAction $action): Response
    {
        return $action($request);
    }

    public function verifyEmail(VerifyEmailRequest $request, VerifyEmailAction $action): JsonResponse
    {
        return $action($request->validated());
    }
}
