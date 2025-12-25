<?php

namespace App\Actions\Commitment;

use App\Actions\Streak\UpdateStreakAction;
use Illuminate\Validation\ValidationException;

class CheckCommitmentAction
{
    public function __construct(
        private UpdateStreakAction $updateStreakAction
    ) {}

    public function execute($commitment)
    {
        $this->validate($commitment);

        if ($commitment->commitment_date < now()->toDateString()) {
            $commitment->update(['status' => 'missed']);
            $this->updateStreakAction->execute($commitment->user, 'missed');

            return;
        }

        $commitment->update([
            'status' => 'checked',
            'checked_at' => now()->toDateTimeString(),
        ]);

        $this->updateStreakAction->execute($commitment->user, 'checked');
    }

    private function validate($commitment)
    {
        if ($commitment->status != 'pending') {
            throw ValidationException::withMessages([
                'commitment' => 'Only pending commitments can be checked.',
            ]);
        }
    }
}
