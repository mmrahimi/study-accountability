<?php

use App\Models\Commitment;
use App\Models\Subject;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

describe('cache related tests on the commitment model', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);

        $this->subject = Subject::factory()->for($this->user)->create();
    });

    it('caches user commitments by status on first fetch', function () {
        Cache::flush();

        Commitment::factory()->create([
            'user_id' => $this->user->id,
            'subject_id' => $this->subject->id,
        ]);

        $first = $this->getJson('/api/commitments?status=pending')
            ->assertOk()
            ->json('commitments');

        Commitment::factory()->create([
            'user_id' => $this->user->id,
            'subject_id' => $this->subject->id,
        ]);

        $second = $this->getJson('/api/commitments?status=pending')
            ->assertOk()
            ->json('commitments');

        expect(count($first))->toBe(1)
            ->and(count($second))->toBe(1);
    });
});
