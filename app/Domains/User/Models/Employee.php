<?php

declare(strict_types=1);

namespace Domains\User\Models;

use Core\Enums\UserStatusEnum;
use Core\Traits\HasUuid;
use Domains\User\Contracts\HasProfileContract;
use Domains\User\Observers\EmployeeObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Employee extends Authenticatable implements HasProfileContract, JWTSubject
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'status',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'status'            => UserStatusEnum::class,
        ];
    }

    public function profile(): HasOne
    {
        return $this->hasOne(EmployeeProfile::class);
    }

    public function profileModel(): string
    {
        return EmployeeProfile::class;
    }

    public function profileForeignKey(): string
    {
        return 'employee_id';
    }

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return ['guard' => 'employee'];
    }
}