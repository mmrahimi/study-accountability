<?php

namespace App\Actions\Commitment;

use Illuminate\Support\Facades\Cache;

class FetchUserCommitmentsAction
{
    public function execute($user, $status)
    {
        return Cache::remember(
            "commitments:user:{$user->id}:status:{$status}",
            now()->addMinutes(10),
            fn () => $user->commitments()
                ->where('status', $status)
                ->orderBy('commitment_date')
                ->get()
        );
    }
}
