<?php

namespace App\Actions\Commitment;

use App\Actions\Streak\UpdateStreakAction;
use App\Models\Commitment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class CheckCommitmentAction
{
    public function __construct(
        private UpdateStreakAction $updateStreakAction
    ) {}

    public function execute($user, $commitment)
    {
        $this->validate($commitment);

        if ($commitment->commitment_date < now()->toDateString()) {
            $commitment->update(['status' => Commitment::STATUS_MISSED]);
            $this->updateStreakAction->execute($commitment->user, Commitment::STATUS_MISSED);

            return;
        }

        $commitment->update([
            'status' => Commitment::STATUS_CHECKED,
            'checked_at' => now()->toDateTimeString(),
        ]);

        foreach (Commitment::STATUSES as $status) {
            Cache::forget("commitments:user:{$user->id}:status:{$status}");
        }

        $this->updateStreakAction->execute($commitment->user, Commitment::STATUS_CHECKED);
    }

    private function validate($commitment)
    {
        if ($commitment->status != Commitment::STATUS_PENDING) {
            throw ValidationException::withMessages([
                'commitment' => 'Only pending commitments can be checked.',
            ]);
        }
    }
}
