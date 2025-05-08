<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Models\Project;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function index(Project $project)
    {
        return $project->labels;
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7',
        ]);

        $label = $project->labels()->create($validated);

        return response()->json($label, 201);
    }

    public function update(Request $request, Label $label)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7',
        ]);

        $label->update($validated);

        return response()->json($label);
    }

    public function destroy(Label $label)
    {
        $label->delete();
        return response()->noContent();
    }

    public function attach(Request $request, Label $label)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
        ]);

        $label->tasks()->attach($validated['task_id']);

        return response()->json($label->fresh('tasks'));
    }

    public function detach(Request $request, Label $label)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
        ]);

        $label->tasks()->detach($validated['task_id']);

        return response()->json($label->fresh('tasks'));
    }
} 