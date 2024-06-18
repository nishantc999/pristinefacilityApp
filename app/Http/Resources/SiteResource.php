<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {

        $shifts = $this->shifts->unique('id')->map(function ($shift) {
            $shift->pivot_site_id = $this->id;
            return $shift;
        });
        return [
            'id' => $this->id,
            'name' => $this->name,
            'client' => new ClientResource($this->whenLoaded('client')),
            'shifts' => ShiftResource::collection($shifts),
            // 'areas' => AreaResource::collection($this->whenLoaded('areas')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
