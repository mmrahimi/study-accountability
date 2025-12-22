<?php

namespace App\Http\Controllers;

use App\Actions\Commitment\FetchUserCommitmentsAction;
use App\Actions\Commitment\ShowCommitmentAction;
use App\Actions\Commitment\StoreCommitmentAction;
use App\Http\Requests\FetchUserCommitmentsRequest;
use App\Http\Requests\StoreCommitmentRequest;
use App\Http\Resources\CommitmentResource;
use App\Models\Commitment;
use Illuminate\Http\Request;

class CommitmentController extends Controller
{
    public function index(FetchUserCommitmentsRequest $request, FetchUserCommitmentsAction $action)
    {
        return response()->json([
            'commitments' => CommitmentResource::collection($action->execute($request->user(), $request->status)),
        ]);
    }

    public function store(StoreCommitmentRequest $request, StoreCommitmentAction $action)
    {
        $action->execute($request->user(), $request->validated());

        return response()->json([
            'message' => 'Commitment created successfully',
        ], 201);
    }

    public function show(Commitment $commitment, ShowCommitmentAction $action)
    {
        $this->authorize('view', $commitment);

        return response()->json([
            'commitment' => new CommitmentResource($action->execute($commitment)),
        ]);
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
