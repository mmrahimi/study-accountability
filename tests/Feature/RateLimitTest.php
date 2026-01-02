<?php

use App\Models\User;

test('that the general rate limiter works', function () {
    RateLimiter::clear('general');

    $user = User::factory()->create();

    $hit = fn() => $this->actingAs($user)
        ->getJson('/api/streak');

    $max = RateLimiter::limiter('general')(request())->maxAttempts;

    for ($i = 0; $i < $max; $i++) {
        $hit()->assertOk();
    }

    $hit()->assertTooManyRequests();
});
