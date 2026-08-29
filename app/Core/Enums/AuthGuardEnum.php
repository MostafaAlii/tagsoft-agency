<?php

namespace Core\Enums;

enum AuthGuardEnum: string
{
    case ADMIN = 'admin';
    case CLIENT = 'client';
    case COMPANY = 'company';
    case EMPLOYEE = 'employee';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}