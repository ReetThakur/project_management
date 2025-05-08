<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    // ... existing code ...

    public function move(Request $request, Task $task)
    {
        $validated = $request->validate([
            'column_id' => 'required|exists:columns,id',
            'order' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($task, $validated) {
            // Update the order of other tasks in the new column
            Task::where('column_id', $validated['column_id'])
                ->where('order', '>=', $validated['order'])
                ->increment('order');

            // Move the task to the new column and position
            $task->update([
                'column_id' => $validated['column_id'],
                'order' => $validated['order'],
            ]);
        });

        return response()->json($task->fresh(['assignee:id,name,avatar']));
    }
} 