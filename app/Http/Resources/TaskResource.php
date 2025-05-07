<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'due_date' => $this->due_date->format('Y-m-d'),
            'project' => [
                'id' => $this->project->id,
                'title' => $this->project->title,
            ],
            'assignee' => [
                'id' => $this->assignee->id,
                'name' => $this->assignee->name,
            ],
            'comments_count' => $this->comments->count(),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
