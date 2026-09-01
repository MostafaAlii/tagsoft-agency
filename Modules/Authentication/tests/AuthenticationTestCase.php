<?php

declare(strict_types=1);

namespace Authentication\Tests;

use Domains\User\Models\{Admin, Client, Employee};
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

abstract class AuthenticationTestCase extends TestCase
{
    protected function loginAndGetToken(string $guard, string $modelClass): array
    {
        $user = $modelClass::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson("/api/{$guard}/login", [
            'email'    => $user->email,
            'password' => 'password123',
        ]);

        return [
            'user'  => $user,
            'token' => $response->json('data.access_token'),
        ];
    }

    public static function guardsDataset(): array
    {
        return [
            'admin'    => ['admin', Admin::class],
            'client'   => ['client', Client::class],
            'employee' => ['employee', Employee::class],
        ];
    }
}