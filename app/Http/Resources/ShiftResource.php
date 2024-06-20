<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShiftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {

        $areas = $this->areas->unique('id')->map(function ($area) {
            $area->pivot_shift_id = $this->id;
            $area->pivot_site_id = $this->pivot->site_id;
            return $area;
        });

        return [
            'id' => $this->id,
            'name' => $this->name,
            // 'areas' => AreaResource::collection($this->whenLoaded('areas')),
           'areas' => AreaResource::collection($areas),
            // 'checklists' => ChecklistResource::collection($this->whenLoaded('checklists')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
