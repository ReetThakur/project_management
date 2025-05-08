<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Task;
use App\Models\Notification;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Send task due reminders daily at 8 AM
        $schedule->call(function () {
            $tasks = Task::whereDate('due_date', now()->addDay())
                        ->with(['assignee', 'project'])
                        ->get();

            foreach ($tasks as $task) {
                Notification::create([
                    'type' => 'task_due_reminder',
                    'notifiable_type' => Task::class,
                    'notifiable_id' => $task->id,
                    'user_id' => $task->assigned_to,
                    'data' => [
                        'message' => "Task '{$task->title}' in project '{$task->project->title}' is due tomorrow!",
                        'link' => route('tasks.show', $task),
                    ],
                ]);
            }
        })->dailyAt('08:00');

        $schedule->command('tasks:check-due-dates')->daily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
} 