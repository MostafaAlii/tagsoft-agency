<?php

declare(strict_types=1);

namespace Domains\User\Factories;

use Core\Helpers\UuidHelper;
use Domains\User\Contracts\HasProfileContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Throwable;

final class ProfileFactory
{
    /**
     * Create the profile record for the given owner model.
     *
     * @throws Throwable
     */
    public static function makeFor(HasProfileContract $owner): Model
    {
        $profileClass = $owner->profileModel();
        $foreignKey   = $owner->profileForeignKey();

        try {
            return $profileClass::create([
                'uuid'      => UuidHelper::generate(),
                $foreignKey => $owner->getKey(),
            ]);
        } catch (Throwable $e) {
            Log::error('Failed to create profile via ProfileFactory', [
                'owner_class'   => $owner::class,
                'owner_id'      => $owner->getKey(),
                'profile_class' => $profileClass,
                'foreign_key'   => $foreignKey,
                'exception'     => $e->getMessage(),
                'trace'         => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }
}