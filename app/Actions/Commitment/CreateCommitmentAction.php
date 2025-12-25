<?php

namespace App\Actions\Commitment;

use Illuminate\Validation\ValidationException;

class CreateCommitmentAction
{
    public function execute($user, $data)
    {
        $data['commitment_date'] = now()->toDateString();

        $this->markExpiredCommitmentsAsMissed($user);

        $this->validate($user, $data);

        $user->commitments()
            ->create($data);
    }

    private function validate($user, $data)
    {
        if (! $user->subjects()->whereKey($data['subject_id'])->exists()) {
            throw ValidationException::withMessages([
                'subject_id' => 'Invalid subject.',
            ]);
        }

        if ($user->commitments()->whereDate('commitment_date', now()->toDateString())->where('status', 'pending')->exists()) {
            throw ValidationException::withMessages([
                'commitment' => 'You already have a pending commitment for today.',
            ]);
        }
    }

    private function markExpiredCommitmentsAsMissed($user)
    {
        $user->commitments()
            ->where('status', 'pending')
            ->whereDate('commitment_date', '<', now()->toDateString())
            ->update(['status' => 'missed']);
    }
}
