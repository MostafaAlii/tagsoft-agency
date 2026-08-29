<?php

namespace Core\Enums;

enum AdminTypeEnum: string
{
    case OWNER = 'owner';
    case COMPANY_ADMIN = 'company_admin';
    case BRANCH_ADMIN = 'branch_admin';

    public function isOwner(): bool
    {
        return $this === self::OWNER;
    }

    public function isCompanyAdmin(): bool
    {
        return $this === self::COMPANY_ADMIN;
    }

    public function isBranchAdmin(): bool
    {
        return $this === self::BRANCH_ADMIN;
    }

    public function label(): string
    {
        return match ($this) {
            self::OWNER => trans('dashboard/general.owner'),
            self::COMPANY_ADMIN => trans('dashboard/general.company_admin'),
            self::BRANCH_ADMIN => trans('dashboard/general.branch_admin'),
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::OWNER => '<span class="badge bg-primary">' . $this->label() . '</span>',
            self::COMPANY_ADMIN => '<span class="badge bg-info">' . $this->label() . '</span>',
            self::BRANCH_ADMIN => '<span class="badge bg-secondary">' . $this->label() . '</span>',
        };
    }
}
