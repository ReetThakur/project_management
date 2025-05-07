<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        // Load the project relationship if it's not already loaded
        if (!$task->relationLoaded('project')) {
            $task->load('project');
        }

        return $user->isAdmin() || 
               ($user->isManager() && $task->project->created_by === $user->id) ||
               ($user->isMember() && $task->assigned_to === $user->id) ||
               // Add this condition to allow users to view tasks they have notifications about
               $user->notifications()->where('task_id', $task->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isManager();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->isAdmin() || 
               ($user->isManager() && $task->project->created_by === $user->id) ||
               ($user->isMember() && $task->assigned_to === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->isAdmin() || 
               ($user->isManager() && $task->project->created_by === $user->id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return false;
    }
}
