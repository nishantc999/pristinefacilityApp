<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
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
            'checklist_variable_id' => $this->checklist_variable_id,
            'rating' => $this->rating,
            'status' => $this->status,
            'remark' => $this->remark,
            'media' => $this->media,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // 'rating_given_by' => new UserResource($this->whenLoaded('ratingGiver')), // Assuming a relationship with the user who gave the rating
        ];
    }
}
