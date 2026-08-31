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

    public function label(): string
    {
        return match ($this) {
            self::ADMIN    => 'Admin',
            self::CLIENT   => 'Client',
            self::EMPLOYEE => 'Employee',
        };
    }

    public function modelClass(): string
    {
        return match ($this) {
            self::ADMIN    => \Domains\User\Models\Admin::class,
            self::CLIENT   => \Domains\User\Models\Client::class,
            self::EMPLOYEE => \Domains\User\Models\Employee::class,
        };
    }
}