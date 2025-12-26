<?php

namespace App\Actions\Commitment;

use App\Models\Commitment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class UpdateCommitmentAction
{
    public function execute($user, $commitment, $data)
    {
        $this->validate($user, $data);

        $commitment->update($data);

        foreach (Commitment::STATUSES as $status) {
            Cache::forget("commitments:user:{$user->id}:status:{$status}");
        }
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
