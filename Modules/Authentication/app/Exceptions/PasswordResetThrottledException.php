<?php

declare(strict_types=1);

namespace Authentication\Exceptions;

final class PasswordResetThrottledException extends PasswordException
{
    public function __construct()
    {
        parent::__construct(trans('authentication::general\account_status.password_reset_throttled'));
    }

    public function statusCode(): int
    {
        return 429;
    }
}