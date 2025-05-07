<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\ProjectResource;
use App\Traits\NotificationTrait;

class ProjectController extends Controller
{
    use NotificationTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::query();

        if ($request->user()->isMember()) {
            $query->whereHas('tasks', function($q) use ($request) {
                $q->where('assigned_to', $request->user()->id);
            });
        } elseif ($request->user()->isManager()) {
            $query->where('created_by', $request->user()->id);
        }

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('status')) {
            $query->where('status', $request->get('status'));
        }

        $projects = $query->with(['creator', 'tasks'])
                         ->latest()
                         ->paginate(10);

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('create', Project::class)) {
            abort(403);
        }
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Gate::allows('create', Project::class)) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,completed',
        ]);

        try {
            $project = Project::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'start_date' => $validated['start_date'],
                'due_date' => $validated['due_date'],
                'status' => $validated['status'],
                'created_by' => $request->user()->id,
            ]);

            return $this->successMessage(
                'Project created successfully!',
                'projects.show',
                ['project' => $project->id]
            );
        } catch (\Exception $e) {
            return $this->errorMessage('Failed to create project. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load(['creator', 'tasks.assignee', 'tasks.comments.user']);

        
        if (!Gate::allows('view', $project)) {
            abort(403);
        }

        $project->load(['creator', 'tasks.assignee', 'tasks.comments.user']);

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        if (!Gate::allows('update', $project)) {
            abort(403);
        }
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        if (!Gate::allows('update', $project)) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,completed',
        ]);

        $project->update($validated);

        return $this->successMessage(
            'Project updated successfully.',
            'projects.show',
            ['project' => $project->id]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if (!Gate::allows('delete', $project)) {
            abort(403);
        }
        
        $project->delete();

        return $this->successMessage('Project deleted successfully.');
    }
}
