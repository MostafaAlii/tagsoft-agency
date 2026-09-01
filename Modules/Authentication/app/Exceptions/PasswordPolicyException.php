<?php

declare(strict_types=1);

namespace Authentication\Exceptions;

final class PasswordPolicyException extends PasswordException
{
    public function __construct(
        private readonly array $errors = [],
    ) {
        parent::__construct(trans('authentication::general\account_status.password_policy_failed'));
    }

    public function statusCode(): int
    {
        return 422;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}