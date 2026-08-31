<?php

declare(strict_types=1);

namespace Domains\User\Models;

use Core\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeProfile extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'uuid',
        'employee_id',
        'department',
        'position',
        'hired_at',
    ];
    protected string $uuidField = 'uuid';
    protected function casts(): array
    {
        return [
            'hired_at' => 'date',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}