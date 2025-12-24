<?php

namespace App\Http\Controllers;

use App\Actions\Streak\FetchStreakAction;
use App\Http\Resources\StreakResource;
use Illuminate\Http\Request;

class StreakController extends Controller
{
    public function show(Request $request, FetchStreakAction $action)
    {
        return response()->json([
            'streak' => new StreakResource($action->execute($request->user())),
        ]);
    }
}
