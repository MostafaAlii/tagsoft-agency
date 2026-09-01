<?php

declare(strict_types=1);

namespace Authentication\Exceptions;

final class CurrentPasswordIncorrectException extends PasswordException
{
    public function __construct()
    {
        parent::__construct(trans('authentication::general\account_status.current_password_incorrect'));
    }

    public function statusCode(): int
    {
        return 422;
    }
}