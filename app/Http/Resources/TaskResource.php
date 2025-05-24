<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'formatted_status' => Str::replace('_', ' ', Str::ucfirst($this->status)),
            'priority' => $this->priority,
            'formatted_priority' => Str::ucfirst($this->priority),
            'due_date' => $this->due_date,
            'formatted_due_date' => optional($this->due_date)->format('m/d/Y'),
            'assigned_to' => $this->assigned_to,
            'formatted_assigned_to' => $this->whenLoaded('assignee')?->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
