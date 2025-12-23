<?php

namespace App\Actions\Commitment;

use Illuminate\Validation\ValidationException;

class CheckCommitmentAction
{
    public function execute($commitment)
    {
        $this->validate($commitment);

        if ($commitment->commitment_date < now()->toDateString()) {
            $commitment->update(['status' => 'missed']);

            return;
        }

        $commitment->update([
            'status' => 'checked',
            'checked_at' => now()->toDateTimeString(),
        ]);
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
