<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommitmentResource extends JsonResource
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
            'commitment_date' => $this->commitment_date,
            'status' => $this->status,
            'checked_at' => $this->checked_at,
            'subject' => new SubjectResource($this->subject),
        ];
    }
}
