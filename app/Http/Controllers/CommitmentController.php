<?php

namespace App\Http\Controllers;

use App\Actions\Commitment\FetchUserCommitmentsAction;
use App\Http\Requests\FetchUserCommitmentsRequest;
use App\Http\Resources\CommitmentResource;
use Illuminate\Http\Request;

class CommitmentController extends Controller
{
    public function index(FetchUserCommitmentsRequest $request, FetchUserCommitmentsAction $action)
    {
        return response()->json([
            'commitments' => CommitmentResource::collection($action->execute($request->user(), $request->status)),
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function cancel()
    {
        //
    }
}
