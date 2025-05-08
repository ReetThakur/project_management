<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Column;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColumnController extends Controller
{
    public function index(Project $project)
    {
        return $project->columns()
            ->with(['tasks' => function ($query) {
                $query->orderBy('order')
                    ->with(['assignee:id,name,avatar']);
            }])
            ->orderBy('order')
            ->get();
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);

        $column = $project->columns()->create([
            'title' => $validated['title'],
            'color' => $validated['color'] ?? null,
            'order' => $project->columns()->count(),
        ]);

        return response()->json($column, 201);
    }

    public function update(Request $request, Column $column)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);

        $column->update($validated);

        return response()->json($column);
    }

    public function destroy(Column $column)
    {
        DB::transaction(function () use ($column) {
            // Move all tasks to the first column or delete them
            $firstColumn = $column->project->columns()
                ->where('id', '!=', $column->id)
                ->orderBy('order')
                ->first();

            if ($firstColumn) {
                $column->tasks()->update(['column_id' => $firstColumn->id]);
            } else {
                $column->tasks()->delete();
            }

            $column->delete();
        });

        return response()->noContent();
    }

    public function reorder(Request $request, Project $project)
    {
        $validated = $request->validate([
            'columns' => 'required|array',
            'columns.*.id' => 'required|exists:columns,id',
            'columns.*.order' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['columns'] as $columnData) {
                Column::where('id', $columnData['id'])
                    ->update(['order' => $columnData['order']]);
            }
        });

        return response()->noContent();
    }
} 