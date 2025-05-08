<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChecklistItemController extends Controller
{
    public function store(Request $request, Checklist $checklist)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $item = $checklist->items()->create([
            'content' => $validated['content'],
            'order' => $checklist->items()->count(),
        ]);

        return response()->json($item, 201);
    }

    public function update(Request $request, ChecklistItem $item)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:255',
            'is_completed' => 'boolean',
        ]);

        if (isset($validated['is_completed']) && $validated['is_completed']) {
            $validated['completed_at'] = now();
            $validated['completed_by'] = auth()->id();
        } else {
            $validated['completed_at'] = null;
            $validated['completed_by'] = null;
        }

        $item->update($validated);

        return response()->json($item);
    }

    public function destroy(ChecklistItem $item)
    {
        $item->delete();
        return response()->noContent();
    }

    public function reorder(Request $request, Checklist $checklist)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:checklist_items,id',
            'items.*.order' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['items'] as $itemData) {
                ChecklistItem::where('id', $itemData['id'])
                    ->update(['order' => $itemData['order']]);
            }
        });

        return response()->noContent();
    }
} 