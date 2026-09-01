<?php
declare(strict_types=1);
namespace Authentication\Contracts;
interface PasswordManagerInterface {
    public function sendResetLink(string $guard, string $email): void;
    public function reset(string $guard, string $email, string $token, string $password): void;
}