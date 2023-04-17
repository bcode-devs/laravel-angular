<?php

namespace Modules\Auth\UseCases\API\Auth;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Modules\Auth\Http\Resources\AuthResource;
use Modules\Shared\Entities\User\User;
use Modules\Auth\Job\AuthSuccessJobs;
use Illuminate\Http\JsonResponse;
use DomainException;

final class VerifyEmailAction
{
    use ActionTrait;

    public function __invoke(array $request): JsonResponse|AuthResource
    {
        /** @var User $user */
        if (!$user = User::query()->where('verify_token', $request['token'])->first()) {
            return response()->json(
                [
                    'message' => __('auth::validation.email_identified_failed')
                ],
                ResponseAlias::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $this->verify($user->id);
            $user->save();
            AuthSuccessJobs::dispatch($user);
            return response()->json(['message' => __('auth::validation.email_identified')], ResponseAlias::HTTP_OK);
        } catch (DomainException $e) {
            return response()->json(['message' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function verify($id): void
    {
        /** @var User $user */
        $user = User::query()->findOrFail($id);
        $user->verify();
    }
}
