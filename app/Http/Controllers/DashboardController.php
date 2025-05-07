<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = $user->isAdmin() ? Task::query() : 
                ($user->isManager() ? Task::whereHas('project', function($q) use ($user) {
                    $q->where('created_by', $user->id);
                }) : Task::where('assigned_to', $user->id));

        return view('dashboard', [
            'totalProjects' => $user->isAdmin() ? Project::count() : 
                             ($user->isManager() ? Project::where('created_by', $user->id)->count() : 
                             Project::whereHas('tasks', function($q) use ($user) {
                                 $q->where('assigned_to', $user->id);
                             })->count()),
            'tasksDueToday' => $query->clone()->dueToday()->count(),
            'tasksDueThisWeek' => $query->clone()->dueThisWeek()->count(),
            'recentTasks' => $query->with(['project', 'assignee'])
                                 ->latest()
                                 ->take(5)
                                 ->get(),
            'notifications' => $user->notifications()
                                  ->where('read', false)
                                  ->latest()
                                  ->take(5)
                                  ->get(),
        ]);
    }
} 