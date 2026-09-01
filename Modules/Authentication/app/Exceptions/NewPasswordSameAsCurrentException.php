<?php

declare(strict_types=1);

namespace Authentication\Exceptions;

final class NewPasswordSameAsCurrentException extends PasswordException
{
    public function __construct()
    {
        parent::__construct(trans('authentication::general\account_status.new_password_same_as_current'));
    }

    public function statusCode(): int
    {
        return 422;
    }
}