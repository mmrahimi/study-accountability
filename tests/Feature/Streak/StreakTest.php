<?php

use App\Models\Commitment;
use App\Models\Subject;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('creates a streak when user gets created', function () {
    $user = User::factory()->create();

    expect($user->streak)->not()->toBeNull()
        ->and($user->streak->current)->toBe(0)
        ->and($user->streak->longest)->toBe(0);
});

it('returns current and longest streak', function () {
    Sanctum::actingAs(User::factory()->create());

    $response = $this->getJson('/api/streak');

    $response
        ->assertOk()
        ->assertJsonStructure([
            'streak' => ['current', 'longest'],
        ]);
});

describe('streak update scenarios', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);

        $this->subject = Subject::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $this->commitment = Commitment::factory()->create([
            'user_id' => $this->user->id,
            'subject_id' => $this->subject->id,
        ]);
    });

    it('increments streak when commitment is checked', function () {
        $this->postJson("/api/commitments/{$this->commitment->id}/check");

        $this->user->refresh();

        expect($this->user->streak->current)->toBe(1)
            ->and($this->user->streak->longest)->toBe(1);
    });

    it('resets streak when commitment is missed', function () {
        $this->user->streak->update([
            'current' => 3, 'longest' => 3,
        ]);

        $this->commitment->update([
            'commitment_date' => now()->subDay()->toDateString(),
        ]);

        $this->postJson("/api/commitments/{$this->commitment->id}/check");

        $this->user->refresh();

        expect($this->user->streak->current)->toBe(0)
            ->and($this->user->streak->longest)->toBe(3);
    });
});
