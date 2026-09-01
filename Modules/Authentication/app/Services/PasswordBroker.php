<?php
declare(strict_types=1);
namespace Authentication\Services;
use Authentication\Contracts\PasswordBrokerInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\{DB, Hash};
use Illuminate\Support\Str;
final class PasswordBroker implements PasswordBrokerInterface {
    private const TABLE = 'password_reset_tokens';
    public function __construct(
        private readonly int $expireMinutes = 60,
        private readonly int $throttleSeconds = 60,
    ) {}

    public function createToken(Authenticatable $user, string $guard): string {
        $this->deleteToken($user, $guard);
        $plainToken = Str::random(64);
        DB::table(self::TABLE)->insert([
            'resettable_id'   => $user->getKey(),
            'resettable_type' => $user::class,
            'guard'           => $guard,
            'email'           => $user->email,
            'token'           => Hash::make($plainToken),
            'expires_at'      => now()->addMinutes($this->expireMinutes),
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
        return $plainToken;
    }

    public function tokenExists(Authenticatable $user, string $guard, string $token): bool {
        $record = DB::table(self::TABLE)
            ->where('resettable_id', $user->getKey())
            ->where('resettable_type', $user::class)
            ->where('guard', $guard)
            ->first();

        if (!$record) {
            return false;
        }

        if (now()->greaterThan($record->expires_at)) {
            $this->deleteToken($user, $guard);
            return false;
        }
        return Hash::check($token, $record->token);
    }

    public function deleteToken(Authenticatable $user, string $guard): void {
        DB::table(self::TABLE)
            ->where('resettable_id', $user->getKey())
            ->where('resettable_type', $user::class)
            ->where('guard', $guard)
            ->delete();
    }

    public function recentlyCreatedToken(Authenticatable $user, string $guard): bool {
        $record = DB::table(self::TABLE)
            ->where('resettable_id', $user->getKey())
            ->where('resettable_type', $user::class)
            ->where('guard', $guard)
            ->first();
        if (!$record) {
            return false;
        }
        return now()->diffInSeconds($record->created_at) < $this->throttleSeconds;
    }
}