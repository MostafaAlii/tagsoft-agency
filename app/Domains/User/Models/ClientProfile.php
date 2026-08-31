<?php

declare(strict_types=1);

namespace Domains\User\Models;

use Core\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientProfile extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'uuid',
        'client_id',
        'address',
        'city',
        'birth_date',
    ];
    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}