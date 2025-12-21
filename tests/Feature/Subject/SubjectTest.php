<?php

use App\Models\Subject;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

describe('CRUD operation tests on subjects', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    });

    it('fetches all subjects', function () {
        $this->getJson('/api/subjects')
            ->assertOk()
            ->assertJsonStructure(['subjects']);
    });

    it('fetches a single subject', function () {
        $subject = Subject::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $this->getJson("/api/subjects/$subject->id")
            ->assertOk()
            ->assertJsonStructure(['subject']);
    });

    it('cannot view another users subject', function () {
        $otherUser = User::factory()->create();

        $subject = Subject::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $this->getJson("/api/subjects/$subject->id")
            ->assertForbidden();
    });

    it('creates a new subject', function () {
        $this->postJson('/api/subjects', [
            'title' => 'title',
        ])->assertCreated();
    });

    it('updates a subject', function () {
        $subject = Subject::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $this->putJson("/api/subjects/$subject->id", [
            'title' => 'UPDATE',
        ])
            ->assertOk()
            ->assertJson(['message' => 'Subject updated successfully']);
    });

    it('cannot update another users subject', function () {
        $otherUser = User::factory()->create();

        $subject = Subject::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $this->putJson("/api/subjects/$subject->id", [
            'title' => 'TITLE',
        ])->assertForbidden();
    });

    it('deletes a subject', function () {
        $subject = Subject::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $this->deleteJson("/api/subjects/$subject->id")
            ->assertOk()
            ->assertJson(['message' => 'Subject deleted successfully']);
    });

    it('cannot delete another users subject', function () {
        $otherUser = User::factory()->create();

        $subject = Subject::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $this->deleteJson("/api/subjects/$subject->id")
            ->assertForbidden();
    });
});
