<?php

namespace App\Http\Controllers;

use App\Actions\Commitment\CancelCommitmentAction;
use App\Actions\Commitment\CheckCommitmentAction;
use App\Actions\Commitment\CreateCommitmentAction;
use App\Actions\Commitment\FetchUserCommitmentsAction;
use App\Actions\Commitment\ShowCommitmentAction;
use App\Actions\Commitment\UpdateCommitmentAction;
use App\Http\Requests\FetchUserCommitmentsRequest;
use App\Http\Requests\StoreCommitmentRequest;
use App\Http\Requests\UpdateCommitmentRequest;
use App\Http\Resources\CommitmentResource;
use App\Models\Commitment;

class CommitmentController extends Controller
{
    public function index(FetchUserCommitmentsRequest $request, FetchUserCommitmentsAction $action)
    {
        return response()->json([
            'commitments' => CommitmentResource::collection($action->execute($request->user(), $request->status)),
        ]);
    }

    public function store(StoreCommitmentRequest $request, CreateCommitmentAction $action)
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

    public function update(UpdateCommitmentRequest $request, Commitment $commitment, UpdateCommitmentAction $action)
    {
        $this->authorize('update', $commitment);

        $action->execute($request->user(), $commitment, $request->validated());

        return response()->json([
            'message' => 'Commitment updated successfully',
            'commitment' => new CommitmentResource($commitment),
        ]);
    }

    public function cancel(Commitment $commitment, CancelCommitmentAction $action)
    {
        $this->authorize('cancel', $commitment);

        $action->execute($commitment);

        return response()->json([
            'message' => 'Commitment canceled successfully',
        ]);
    }

    public function check(Commitment $commitment, CheckCommitmentAction $action)
    {
        $this->authorize('check', $commitment);

        $action->execute($commitment);

        return response()->json([
            'message' => 'Commitment checked successfully',
        ]);
    }
}
