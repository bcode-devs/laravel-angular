<?php

namespace Modules\Auth\UseCases\API\Auth;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

final class SignUpAction
{
    use ActionTrait;

    public function __invoke(array $request): JsonResponse|Response
    {
        $this->register($request);
        return response()->json(__('auth::validation.user_created'), Response::HTTP_CREATED);
    }
}
