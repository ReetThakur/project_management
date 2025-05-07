<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Gate;
use App\Models\Notification;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->user()->isMember()) {
            $query->where('assigned_to', $request->user()->id);
        } elseif ($request->user()->isManager()) {
            $query->whereHas('project', function($q) use ($request) {
                $q->where('created_by', $request->user()->id);
            });
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

        if ($request->has('priority')) {
            $query->where('priority', $request->get('priority'));
        }

        $tasks = $query->with(['project', 'assignee'])
                      ->latest()
                      ->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        if (!Gate::allows('create', Task::class)) {
            abort(403);
        }

        $users = User::all();
        
        return view('tasks.create', compact('project', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        if (!Gate::allows('create', Task::class)) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:todo,in_progress,done',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
            'assigned_to' => 'required|exists:users,id',
        ]);

        // Add the project_id to the validated data
        $validated['project_id'] = $project->id;

        $task = Task::create($validated);

        // Create notification for assigned user
        if ($task->assigned_to !== auth()->id()) {
            $task->notifications()->create([
                'type' => 'task_assigned',
                'message' => "You have been assigned to task: {$task->title}",
                'user_id' => $task->assigned_to,
            ]);
        }

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // Load the project relationship before checking permissions
        $task->load(['project', 'assignee', 'comments.user']);

        if (!Gate::allows('view', $task)) {
            abort(403);
        }

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        if (!Gate::allows('update', $task)) {
            abort(403);
        }

        // Load the task's relationships
        $task->load(['project', 'assignee']);

        // Get projects that the user has access to, including the current task's project
        $projects = Project::where(function($query) use ($task) {
                $query->where('created_by', auth()->id())
                      ->orWhereHas('tasks', function($q) {
                          $q->where('assigned_to', auth()->id());
                      })
                      ->orWhere('id', $task->project_id); // Include the current task's project
            })
            ->get();
        
        $users = User::all();

        return view('tasks.edit', compact('task', 'projects', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if (!Gate::allows('update', $task)) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:todo,in_progress,done',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:users,id',
        ]);

        $oldAssignee = $task->assigned_to;
        $oldStatus = $task->status;

        $task->update($validated);

        // Create notification for new assignee if changed
        if ($task->assigned_to !== $oldAssignee && $task->assigned_to !== auth()->id()) {
            Notification::create([
                'type' => 'task_assigned',
                'message' => "You have been assigned to task: {$task->title}",
                'user_id' => $task->assigned_to,
                'task_id' => $task->id,
                'read' => false
            ]);

            // Also notify the project manager
            if ($task->project->created_by !== auth()->id()) {
                Notification::create([
                    'type' => 'task_assigned',
                    'message' => "Task '{$task->title}' has been assigned to " . $task->assignee->name,
                    'user_id' => $task->project->created_by,
                    'task_id' => $task->id,
                    'read' => false
                ]);
            }
        }

        // Create notification for status change
        if ($task->status !== $oldStatus) {
            // Notify the assignee
            if ($task->assigned_to !== auth()->id()) {
                Notification::create([
                    'type' => 'status_changed',
                    'message' => "Task status changed to {$task->status}: {$task->title}",
                    'user_id' => $task->assigned_to,
                    'task_id' => $task->id,
                    'read' => false
                ]);
            }

            // Notify the project manager
            if ($task->project->created_by !== auth()->id()) {
                Notification::create([
                    'type' => 'status_changed',
                    'message' => "Task '{$task->title}' status changed to {$task->status}",
                    'user_id' => $task->project->created_by,
                    'task_id' => $task->id,
                    'read' => false
                ]);
            }
        }

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if (!Gate::allows('delete', $task)) {
            abort(403);
        }
        
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
}
