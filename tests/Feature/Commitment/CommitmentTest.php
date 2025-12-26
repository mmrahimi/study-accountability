<?php

use App\Models\Commitment;
use App\Models\Subject;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

describe('CRUD operation tests on commitments', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);

        $this->subject = Subject::factory()->create([
            'user_id' => $this->user->id,
        ]);
    });

    it('creates a commitment for today', function () {
        $this->postJson('/api/commitments', [
            'subject_id' => $this->subject->id,
            'title' => 'Study DSA',
        ])->assertCreated();

        $this->assertDatabaseHas('commitments', [
            'user_id' => $this->user->id,
            'status' => Commitment::STATUS_PENDING,
        ]);
    });

    it('prevents creating more than one commitment per day', function () {
        Commitment::factory()->create([
            'user_id' => $this->user->id,
            'subject_id' => $this->subject->id,
        ]);

        $this->postJson('/api/commitments', [
            'subject_id' => $this->subject->id,
            'title' => 'Another one',
        ])->assertUnprocessable();
    });

    it('fetches user commitments by status', function () {
        Commitment::factory()->create([
            'user_id' => $this->user->id,
            'subject_id' => $this->subject->id,
        ]);

        $this->getJson('/api/commitments?status='.Commitment::STATUS_PENDING)
            ->assertOk()
            ->assertJsonStructure(['commitments']);
    });

    it('searches user commitments by the given term', function () {
        Commitment::factory()->create([
            'title' => 'TITLE',
            'description' => 'DESCRIPTION',
            'user_id' => $this->user->id,
            'subject_id' => $this->subject->id,
        ]);

        $this->getJson('/api/commitments/search?term=DESC')
            ->assertOk()
            ->assertJsonCount(1, 'commitments')
            ->assertJsonPath('commitments.0.title', 'TITLE');
    });

    it('checks a pending commitment', function () {
        $commitment = Commitment::factory()->create([
            'user_id' => $this->user->id,
            'subject_id' => $this->subject->id,
        ]);

        $this->postJson("/api/commitments/{$commitment->id}/check")
            ->assertOk();

        $this->assertDatabaseHas('commitments', [
            'id' => $commitment->id,
            'status' => Commitment::STATUS_CHECKED,
        ]);
    });

    it('cannot check a non-pending commitment', function () {
        $commitment = Commitment::factory()->create([
            'user_id' => $this->user->id,
            'subject_id' => $this->subject->id,
            'status' => Commitment::STATUS_CANCELED,
        ]);

        $this->postJson("/api/commitments/{$commitment->id}/check")
            ->assertUnprocessable();
    });

    it('cancels a commitment', function () {
        $commitment = Commitment::factory()->create([
            'user_id' => $this->user->id,
            'subject_id' => $this->subject->id,
        ]);

        $this->postJson("/api/commitments/{$commitment->id}/cancel")
            ->assertOk();

        $this->assertDatabaseHas('commitments', [
            'id' => $commitment->id,
            'status' => Commitment::STATUS_CANCELED,
        ]);
    });

    it('cannot access another users commitment', function () {
        $otherUser = User::factory()->create();

        $commitment = Commitment::factory()->create([
            'user_id' => $otherUser->id,
            'subject_id' => Subject::factory()->create(['user_id' => $otherUser->id])->id,
        ]);

        $this->getJson("/api/commitments/{$commitment->id}")
            ->assertForbidden();
    });
});
