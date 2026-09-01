<?php

declare(strict_types=1);

namespace Authentication\Exceptions;

final class InvalidResetTokenException extends PasswordException
{
    public function __construct()
    {
        parent::__construct(trans('authentication::general\account_status.invalid_reset_token'));
    }

    public function statusCode(): int
    {
        return 422;
    }
}