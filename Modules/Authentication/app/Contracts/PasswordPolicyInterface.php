<?php

declare(strict_types=1);

namespace Authentication\Contracts;

interface PasswordPolicyInterface
{
    public function rules(): array;

    public function passes(string $password): bool;

    public function failureMessages(string $password): array;
}