<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'user_id' => $this->user_id,
            'teem_id' => $this->teem_id,
            'comment' => $this->comment,
            'image' => $this->image,
            'parent_id' => $this->parent_id,
            'replies' => CommentResource::collection($this->whenLoaded('replies'))
        ];
    }
}
