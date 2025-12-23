<?php

namespace App\Actions\Commitment;

use Illuminate\Validation\ValidationException;

class UpdateCommitmentAction
{
    public function execute($user, $commitment, $data)
    {
        $this->validate($user, $data);

        $commitment->update($data);
    }

    private function validate($user, $data)
    {
        if (! $user->subjects()->whereKey($data['subject_id'])->exists()) {
            throw ValidationException::withMessages([
                'subject_id' => 'Invalid subject.',
            ]);
        }
    }
}
