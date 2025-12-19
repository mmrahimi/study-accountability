<?php

namespace App\Http\Controllers;

use App\Actions\Subject\FetchAllSubjectsAction;
use App\Actions\Subject\ShowSubjectAction;
use App\Actions\Subject\StoreSubjectAction;
use App\Actions\Subject\UpdateSubjectAction;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function index(FetchAllSubjectsAction $action)
    {
        return response()->json([
            'subjects' => SubjectResource::collection($action->execute()),
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
        return response()->json([
            'subject' => new SubjectResource($action->execute($subject)),
        ]);
    }

    public function update(UpdateSubjectRequest $request, Subject $subject, UpdateSubjectAction $action)
    {
        $action->execute($subject, $request->validated());

        return response()->json([
            'message' => 'Subject updated successfully',
            'subject' => new SubjectResource($subject),
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
