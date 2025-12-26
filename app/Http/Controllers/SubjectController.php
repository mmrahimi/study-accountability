<?php

namespace App\Http\Controllers;

use App\Actions\Subject\DeleteSubjectAction;
use App\Actions\Subject\FetchUserSubjectsAction;
use App\Actions\Subject\ShowSubjectAction;
use App\Actions\Subject\StoreSubjectAction;
use App\Actions\Subject\UpdateSubjectAction;
use App\Http\Requests\Subject\StoreSubjectRequest;
use App\Http\Requests\Subject\UpdateSubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request, FetchUserSubjectsAction $action)
    {
        return response()->json([
            'subjects' => SubjectResource::collection($action->execute($request->user())),
        ]);
    }

    public function store(StoreSubjectRequest $request, StoreSubjectAction $action)
    {
        $action->execute($request->user(), $request->validated());

        return response()->json([
            'message' => 'Subject created successfully',
        ], 201);
    }

    public function show(Subject $subject, ShowSubjectAction $action)
    {
        $this->authorize('view', $subject);

        return response()->json([
            'subject' => new SubjectResource($action->execute($subject)),
        ]);
    }

    public function update(UpdateSubjectRequest $request, Subject $subject, UpdateSubjectAction $action)
    {
        $this->authorize('update', $subject);

        $action->execute($subject, $request->validated());

        return response()->json([
            'message' => 'Subject updated successfully',
            'subject' => new SubjectResource($subject),
        ]);
    }

    public function destroy(Subject $subject, DeleteSubjectAction $action)
    {
        $this->authorize('delete', $subject);

        $action->execute($subject);

        return response()->json([
            'message' => 'Subject deleted successfully',
        ]);
    }
}
