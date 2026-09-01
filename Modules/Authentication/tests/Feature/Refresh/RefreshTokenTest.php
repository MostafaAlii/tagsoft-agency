<?php

declare(strict_types=1);

use Authentication\Tests\AuthenticationTestCase;

uses(AuthenticationTestCase::class);

it('refreshes the token successfully', function (string $guard, string $modelClass) {
    ['token' => $oldToken] = $this->loginAndGetToken($guard, $modelClass);

    $response = $this->withHeader('Authorization', "Bearer {$oldToken}")
        ->postJson("/api/{$guard}/refresh");

    $response
        ->assertOk()
        ->assertJson([
            'status'  => true,
            'message' => 'Token refreshed successfully',
        ])
        ->assertJsonStructure([
            'data' => ['access_token', 'token_type', 'expires_in'],
        ]);

    expect($response->json('data.access_token'))->not->toBe($oldToken);
})->with([AuthenticationTestCase::class, 'guardsDataset']);

it('invalidates the old token after refresh', function (string $guard, string $modelClass) {
    ['token' => $oldToken] = $this->loginAndGetToken($guard, $modelClass);

    $this->withHeader('Authorization', "Bearer {$oldToken}")
        ->postJson("/api/{$guard}/refresh")
        ->assertOk();

    $response = $this->withHeader('Authorization', "Bearer {$oldToken}")
        ->getJson("/api/{$guard}/me");

    $response->assertStatus(401);
})->with([AuthenticationTestCase::class, 'guardsDataset']);

it('allows using the new token after refresh', function (string $guard, string $modelClass) {
    ['token' => $oldToken] = $this->loginAndGetToken($guard, $modelClass);

    $refreshResponse = $this->withHeader('Authorization', "Bearer {$oldToken}")
        ->postJson("/api/{$guard}/refresh");

    $newToken = $refreshResponse->json('data.access_token');

    $response = $this->withHeader('Authorization', "Bearer {$newToken}")
        ->getJson("/api/{$guard}/me");

    $response->assertOk();
})->with([AuthenticationTestCase::class, 'guardsDataset']);

it('rejects refresh without a token', function (string $guard) {
    $response = $this->postJson("/api/{$guard}/refresh");

    $response->assertStatus(401);
})->with([AuthenticationTestCase::class, 'guardsDataset']);