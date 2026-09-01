<?php

declare(strict_types=1);

namespace Core\Contracts;

interface HasHttpStatusException
{
    public function statusCode(): int;
}