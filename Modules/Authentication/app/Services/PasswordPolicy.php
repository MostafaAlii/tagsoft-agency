<?php

declare(strict_types=1);

namespace Authentication\Services;

use Authentication\Contracts\PasswordPolicyInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

final class PasswordPolicy implements PasswordPolicyInterface
{
    public function rules(): array
    {
        return [
            'required',
            'string',
            Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised(),
        ];
    }

    public function passes(string $password): bool
    {
        return Validator::make(
            ['password' => $password],
            ['password' => $this->rules()]
        )->passes();
    }

    public function failureMessages(string $password): array
    {
        $validator = Validator::make(
            ['password' => $password],
            ['password' => $this->rules()]
        );

        return $validator->errors()->get('password');
    }
}