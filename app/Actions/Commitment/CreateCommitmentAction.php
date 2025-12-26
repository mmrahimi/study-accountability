<?php

namespace App\Actions\Commitment;

use App\Models\Commitment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class CreateCommitmentAction
{
    public function execute($user, $data)
    {
        $this->validate($user, $data);

        $data['commitment_date'] = now()->toDateString();

        $user->commitments()
            ->create($data);

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

        if ($user->commitments()->where('status', Commitment::STATUS_PENDING)->exists()) {
            throw ValidationException::withMessages([
                'commitment' => 'You must resolve your current commitment first.',
            ]);
        }
    }
}
