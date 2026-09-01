<?php

declare(strict_types=1);

use Authentication\Tests\AuthenticationTestCase;

uses(AuthenticationTestCase::class);

it('logs out successfully with a valid token', function (string $guard, string $modelClass) {
    ['token' => $token] = $this->loginAndGetToken($guard, $modelClass);

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->postJson("/api/{$guard}/logout");

    $response
        ->assertOk()
        ->assertJson([
            'status'  => true,
            'message' => 'Logged out successfully',
        ]);
})->with([AuthenticationTestCase::class, 'guardsDataset']);

it('rejects using the same token again after logout', function (string $guard, string $modelClass) {
    ['token' => $token] = $this->loginAndGetToken($guard, $modelClass);

    $this->withHeader('Authorization', "Bearer {$token}")
        ->postJson("/api/{$guard}/logout")
        ->assertOk();

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->getJson("/api/{$guard}/me");

    $response->assertStatus(401);
})->with([AuthenticationTestCase::class, 'guardsDataset']);

it('rejects logout without a token', function (string $guard) {
    $response = $this->postJson("/api/{$guard}/logout");

    $response->assertStatus(401);
})->with([AuthenticationTestCase::class, 'guardsDataset']);

it('rejects logout with a malformed token', function (string $guard) {
    $response = $this->withHeader('Authorization', 'Bearer this-is-not-a-real-token')
        ->postJson("/api/{$guard}/logout");

    $response->assertStatus(401);
})->with([AuthenticationTestCase::class, 'guardsDataset']);