<?php

namespace App\Actions\Commitment;

use App\Models\Commitment;
use Illuminate\Support\Facades\Cache;

class CancelCommitmentAction
{
    public function execute($user, $commitment)
    {
        $commitment->update(['status' => 'canceled']);

        foreach (Commitment::STATUSES as $status) {
            Cache::forget("commitments:user:{$user->id}:status:{$status}");
        }
    }
}
