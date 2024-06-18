<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Checklist;

class AreaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $checklist = Checklist::where('shift_id', $this->pivot_shift_id)
            ->where('site_id', $this->pivot_site_id)
            ->where('area_id', $this->id)
            ->first();

        return [
            'id' => $this->id,
            'name' => $this->name,
            // 'checklists' => ChecklistResource::collection($this->whenLoaded('checklists')),
           'checklist' => $checklist ? new ChecklistResource($checklist) : null,
        ];
    }
}
