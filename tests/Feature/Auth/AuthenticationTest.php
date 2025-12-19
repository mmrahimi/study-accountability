<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

describe('auth tests', function () {
    it('issues a token on login', function () {
        $user = User::factory()->create();

        $response = $this->postJson('/api/auth/login', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response
            ->assertOk()
            ->assertJsonStructure(['token']);
    });

    it('can logout', function () {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/auth/logout')
            ->assertOk()
            ->assertJson(['message' => 'User logged out successfully']);
    });
});
