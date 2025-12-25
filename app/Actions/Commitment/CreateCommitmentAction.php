<?php

namespace App\Actions\Commitment;

use Illuminate\Validation\ValidationException;

class CreateCommitmentAction
{
    public function execute($user, $data)
    {
        $this->validate($user, $data);

        $data['commitment_date'] = now()->toDateString();

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

        if ($user->commitments()->where('status', 'pending')->exists()) {
            throw ValidationException::withMessages([
                'commitment' => 'You must resolve your current commitment first.',
            ]);
        }
    }
}
