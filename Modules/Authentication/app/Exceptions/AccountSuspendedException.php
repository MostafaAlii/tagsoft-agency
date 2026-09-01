<?php

declare(strict_types=1);

namespace Authentication\Exceptions;

final class AccountSuspendedException extends AccountStatusException
{
    public function __construct()
    {
        parent::__construct(trans('authentication::general\account_status.account_suspended'));
    }
}