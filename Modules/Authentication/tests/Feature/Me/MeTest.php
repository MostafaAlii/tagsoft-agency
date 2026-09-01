<?php

declare(strict_types=1);

use Authentication\Tests\AuthenticationTestCase;

uses(AuthenticationTestCase::class);

it('returns the authenticated user with profile loaded', function (string $guard, string $modelClass) {
    ['user' => $user, 'token' => $token] = $this->loginAndGetToken($guard, $modelClass);

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->getJson("/api/{$guard}/me");

    $response
        ->assertOk()
        ->assertJson([
            'status'  => true,
            'message' => 'User retrieved successfully',
            'data'    => [
                'email' => $user->email,
            ],
        ])
        ->assertJsonStructure([
            'data' => ['id', 'uuid', 'name', 'email', 'status', 'profile'],
        ])
        ->assertJsonMissing(['created_at'])
        ->assertJsonMissing(['deleted_at']);
})->with([AuthenticationTestCase::class, 'guardsDataset']);

it('rejects me without a token', function (string $guard) {
    $response = $this->getJson("/api/{$guard}/me");

    $response->assertStatus(401);
})->with([AuthenticationTestCase::class, 'guardsDataset']);

it('rejects me with a malformed token', function (string $guard) {
    $response = $this->withHeader('Authorization', 'Bearer garbage-token-value')
        ->getJson("/api/{$guard}/me");

    $response->assertStatus(401);
})->with([AuthenticationTestCase::class, 'guardsDataset']);

it('rejects a token issued for one guard on another guards protected routes', function (string $guard, string $modelClass) {
    ['token' => $token] = $this->loginAndGetToken($guard, $modelClass);

    $otherGuards = collect(['admin', 'client', 'employee'])
        ->reject(fn(string $g) => $g === $guard)
        ->values();

    foreach ($otherGuards as $otherGuard) {
        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson("/api/{$otherGuard}/me");

        $response->assertStatus(401);
    }
})->with([AuthenticationTestCase::class, 'guardsDataset']);