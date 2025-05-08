<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskDueNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckTaskDueDates extends Command
{
    protected $signature = 'tasks:check-due-dates';
    protected $description = 'Check for tasks that are due soon and send notifications';

    public function handle()
    {
        $tasks = Task::with('assignee')
            ->whereNotNull('due_date')
            ->whereNotNull('assigned_to')
            ->where('due_date', '>', now())
            ->where('due_date', '<=', now()->addDay())
            ->get();

        foreach ($tasks as $task) {
            if ($task->assignee) {
                $task->assignee->notify(new TaskDueNotification($task));
            }
        }

        $this->info('Due date notifications sent successfully.');
    }
} 