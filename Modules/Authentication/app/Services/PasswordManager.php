<?php
declare(strict_types=1);
namespace Authentication\Services;
use Authentication\Contracts\{PasswordBrokerInterface, PasswordManagerInterface};
use Authentication\Exceptions\{InvalidResetTokenException, PasswordResetThrottledException};
use Authentication\Notifications\PasswordResetNotification;
use Core\Enums\AuthGuardEnum;
use Illuminate\Support\Facades\{Hash, Notification};
final class PasswordManager implements PasswordManagerInterface {
    public function __construct(
        private readonly PasswordBrokerInterface $broker,
    ) {}

    public function sendResetLink(string $guard, string $email): void {
        $user = $this->findUser($guard, $email);
        if (!$user) {
            // Silent on purpose — avoids leaking which emails are registered.
            return;
        }
        if ($this->broker->recentlyCreatedToken($user, $guard)) {
            throw new PasswordResetThrottledException();
        }
        $token = $this->broker->createToken($user, $guard);
        Notification::route('mail', $user->email)->notify(new PasswordResetNotification($token, $guard));
    }

    public function reset(string $guard, string $email, string $token, string $password): void {
        $user = $this->findUser($guard, $email);
        if (!$user || !$this->broker->tokenExists($user, $guard, $token)) {
            throw new InvalidResetTokenException();
        }
        $user->password = Hash::make($password);
        $user->save();
        $this->broker->deleteToken($user, $guard);
    }

    private function findUser(string $guard, string $email): ?object {
        $modelClass = AuthGuardEnum::from($guard)->modelClass();
        return $modelClass::where('email', $email)->first();
    }
}