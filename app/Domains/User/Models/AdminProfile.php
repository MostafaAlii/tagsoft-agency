<?php

declare(strict_types=1);

namespace Domains\User\Models;

use Core\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminProfile extends Model
{
    use HasFactory, HasUuid;
    protected $table = 'admin_profiles';
    protected $fillable = [
        'uuid',
        'admin_id',
        'phone',
        'job_title',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}