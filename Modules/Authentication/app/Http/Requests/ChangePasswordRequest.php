<?php

declare(strict_types=1);

namespace Authentication\Http\Requests;

use Authentication\Contracts\PasswordPolicyInterface;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string'],
            'new_password' => [
                ...app(PasswordPolicyInterface::class)->rules(),
                'confirmed',
            ],
        ];
    }
}