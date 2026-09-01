<?php

declare(strict_types=1);

use Authentication\Tests\AuthenticationTestCase;
use Core\Enums\UserStatusEnum;
use Illuminate\Support\Facades\Hash;

uses(AuthenticationTestCase::class);

it('logs in successfully with valid credentials', function (string $guard, string $modelClass) {
    $user = $modelClass::factory()->create([
        'password' => Hash::make('password123'),
    ]);

    $response = $this->postJson("/api/{$guard}/login", [
        'email'    => $user->email,
        'password' => 'password123',
    ]);

    $response
        ->assertOk()
        ->assertJson([
            'status'  => true,
            'message' => 'Logged in successfully',
        ])
        ->assertJsonStructure([
            'data' => [
                'user' => ['id', 'uuid', 'name', 'email', 'status', 'profile'],
                'access_token',
                'token_type',
                'expires_in',
            ],
        ]);

    expect($response->json('data.user.email'))->toBe($user->email);
})->with([AuthenticationTestCase::class, 'guardsDataset']);

it('rejects login with an incorrect password', function (string $guard, string $modelClass) {
    $user = $modelClass::factory()->create([
        'password' => Hash::make('password123'),
    ]);

    $response = $this->postJson("/api/{$guard}/login", [
        'email'    => $user->email,
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(422);
})->with([AuthenticationTestCase::class, 'guardsDataset']);

it('rejects login for a non-existent email', function (string $guard, string $modelClass) {
    $response = $this->postJson("/api/{$guard}/login", [
        'email'    => 'does-not-exist@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(422);
})->with([AuthenticationTestCase::class, 'guardsDataset']);

it('rejects login for an inactive account', function (string $guard, string $modelClass) {
    $user = $modelClass::factory()->create([
        'password' => Hash::make('password123'),
        'status'   => UserStatusEnum::INACTIVE,
    ]);

    $response = $this->postJson("/api/{$guard}/login", [
        'email'    => $user->email,
        'password' => 'password123',
    ]);

    $response
        ->assertStatus(403)
        ->assertJson([
            'status'  => false,
            'message' => trans('auth.account_inactive'),
        ]);
})->with([AuthenticationTestCase::class, 'guardsDataset']);

it('rejects login for a suspended account', function (string $guard, string $modelClass) {
    $user = $modelClass::factory()->create([
        'password' => Hash::make('password123'),
        'status'   => UserStatusEnum::SUSPENDED,
    ]);

    $response = $this->postJson("/api/{$guard}/login", [
        'email'    => $user->email,
        'password' => 'password123',
    ]);

    $response
        ->assertStatus(403)
        ->assertJson([
            'status'  => false,
            'message' => trans('auth.account_suspended'),
        ]);
})->with([AuthenticationTestCase::class, 'guardsDataset']);

it('requires email and password', function (string $guard) {
    $response = $this->postJson("/api/{$guard}/login", []);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['email', 'password']);
})->with([AuthenticationTestCase::class, 'guardsDataset']);