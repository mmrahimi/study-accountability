<?php

namespace App\Http\Controllers;

use App\Actions\Subject\FetchAllSubjectsAction;
use App\Actions\Subject\StoreSubjectAction;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use Illuminate\Http\Request;

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

    public function show(Subject $subject)
    {
        return response()->json([
            'subject' => new SubjectResource($subject),
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
