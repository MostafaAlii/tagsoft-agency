<?php

declare(strict_types=1);

namespace Domains\User\Models;

use Core\Enums\UserStatusEnum;
use Core\Traits\HasUuid;
use Domains\User\Contracts\HasProfileContract;
use Domains\User\Observers\ClientObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Client extends Authenticatable implements HasProfileContract, JWTSubject
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'phone',
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
        return $this->hasOne(ClientProfile::class);
    }

    public function profileModel(): string
    {
        return ClientProfile::class;
    }

    public function profileForeignKey(): string
    {
        return 'client_id';
    }

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return ['guard' => 'client', 'uuid'  => $this->uuid,];
    }
}