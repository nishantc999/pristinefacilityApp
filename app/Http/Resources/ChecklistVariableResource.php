<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChecklistVariableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'checklist_id' => $this->checklist_id,
            'name' => $this->name,
            'feedbacks' => FeedbackResource::collection($this->whenLoaded('feedbacks')),
        ];
    }
}
