<?php

namespace Modules\Auth\Http\Requests\Reset;

use Illuminate\Foundation\Http\FormRequest;

final class PasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => 'required|string|exists:password_reset_tokens',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
