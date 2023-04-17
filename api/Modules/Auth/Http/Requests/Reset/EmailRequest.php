<?php

namespace Modules\Auth\Http\Requests\Reset;

use Illuminate\Foundation\Http\FormRequest;

final class EmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users',
        ];
    }
}
