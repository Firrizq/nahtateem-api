<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeemDetailResource extends JsonResource
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
            'image' => $this->image,
            'writer' => $this->whenLoaded('writer'),
            'comment_total' => $this->whenLoaded('comments', function(){
                return count($this->comments);
            }),
            'comments' => $this->whenLoaded('comments', function(){
                return collect($this->comments)->each(function($comment){
                    $comment->commentator;
                    return $comment;
                });
            }),
            'created_at' => date_format($this->created_at, "y/m/d H:i:s"),
        ];
    }
}
