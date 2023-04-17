<?php

namespace Modules\Auth\UseCases\API\Auth;

use Modules\Auth\Http\Requests\Auth\SignInRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

final class SignInAction
{
    use ActionTrait;

    /**
     * @throws ValidationException
     */
    public function __invoke(SignInRequest $request): Response
    {
        if (!$this->guard()->attempt($request->validated())) {
            return $this->sendFailedLoginResponse($request);
        }
        if ($request->user() && $request->user()->isWait()) {
            throw ValidationException::withMessages([
                'email' => [__('auth::validation.email_not_confirm')]
            ]);
        }
        $request->user()->tokens(config('app.name'))->delete();
        return $this->authenticated($request);
    }
}
