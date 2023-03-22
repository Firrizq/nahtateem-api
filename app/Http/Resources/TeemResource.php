<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'teem' => $this->teems_content,
            'writer' => $this->whenLoaded('writer'),
            // 'created_at' => $this->created_at,
            'created_at' => date_format($this->created_at, "y/m/d H:i:s"),
        ];
    }
}
