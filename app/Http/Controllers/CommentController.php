<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use App\Models\Notification;
use App\Traits\NotificationTrait;

class CommentController extends Controller
{
    use NotificationTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = $task->comments()->create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
        ]);

        // Create notification for task owner
        if ($task->assigned_to !== auth()->id()) {
            Notification::create([
                'type' => 'new_comment',
                'message' => "New comment on task '{$task->title}' by " . auth()->user()->name,
                'user_id' => $task->assigned_to,
                'task_id' => $task->id,
                'read' => false
            ]);
        }

        // Also notify the project manager
        if ($task->project->created_by !== auth()->id()) {
            Notification::create([
                'type' => 'new_comment',
                'message' => "New comment on task '{$task->title}' by " . auth()->user()->name,
                'user_id' => $task->project->created_by,
                'task_id' => $task->id,
                'read' => false
            ]);
        }

        if ($request->wantsJson()) {
            return new CommentResource($comment);
        }

        return $this->successMessage(
            'Comment added successfully!',
            'tasks.show',
            ['task' => $comment->task_id]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update($validated);

        return $this->successMessage(
            'Comment updated successfully!',
            'tasks.show',
            ['task' => $comment->task_id]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $comment->delete();

        return $this->successMessage(
            'Comment deleted successfully!',
            'tasks.show',
            ['task' => $taskId]
        );
    }
}
