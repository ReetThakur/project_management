<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create manager user
        $manager = User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'email_verified_at' => now(),
        ]);

        // Create member user
        $member = User::create([
            'name' => 'Member User',
            'email' => 'member@example.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        // Create sample projects
        $projects = [];
        for ($i = 1; $i <= 5; $i++) {
            $projects[] = Project::create([
                'title' => "Sample Project $i",
                'description' => "This is a sample project description for project $i.",
                'start_date' => now(),
                'due_date' => now()->addDays(30),
                'status' => $i % 2 == 0 ? 'active' : 'completed',
                'created_by' => $manager->id,
            ]);
        }

        // Create sample tasks for each project
        foreach ($projects as $project) {
            for ($i = 1; $i <= 3; $i++) {
                $task = Task::create([
                    'project_id' => $project->id,
                    'title' => "Task $i for {$project->title}",
                    'description' => "This is a sample task description.",
                    'status' => ['todo', 'in_progress', 'done'][rand(0, 2)],
                    'priority' => ['low', 'medium', 'high'][rand(0, 2)],
                    'due_date' => now()->addDays(rand(1, 30)),
                    'assigned_to' => $member->id,
                ]);

                // Add sample comments to each task
                Comment::create([
                    'task_id' => $task->id,
                    'user_id' => $manager->id,
                    'content' => "This is a sample comment on task $i.",
                ]);
            }
        }
    }
}
