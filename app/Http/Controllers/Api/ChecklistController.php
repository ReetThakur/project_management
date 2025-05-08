<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChecklistController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'items' => 'array',
            'items.*.content' => 'required|string|max:255',
        ]);

        $checklist = DB::transaction(function () use ($task, $validated) {
            $checklist = $task->checklists()->create([
                'title' => $validated['title'],
                'order' => $task->checklists()->count(),
            ]);

            if (isset($validated['items'])) {
                foreach ($validated['items'] as $index => $item) {
                    $checklist->items()->create([
                        'content' => $item['content'],
                        'order' => $index,
                    ]);
                }
            }

            return $checklist->load('items');
        });

        return response()->json($checklist, 201);
    }

    public function update(Request $request, Checklist $checklist)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $checklist->update($validated);

        return response()->json($checklist->fresh('items'));
    }

    public function destroy(Checklist $checklist)
    {
        $checklist->delete();
        return response()->noContent();
    }

    public function reorder(Request $request, Task $task)
    {
        $validated = $request->validate([
            'checklists' => 'required|array',
            'checklists.*.id' => 'required|exists:checklists,id',
            'checklists.*.order' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['checklists'] as $checklistData) {
                Checklist::where('id', $checklistData['id'])
                    ->update(['order' => $checklistData['order']]);
            }
        });

        return response()->noContent();
    }
} 