<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class postDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'news_content'  => $this->news_content,
            'image'         => $this->image,
            'writer'        => $this->whenLoaded('writer', function() {
                        return $this->writer['username'];
            }),
            'total_komentar'=> $this->comments->count(),
            'komentar'      => CommentResource::collection($this->comments),    
            'created_at'    => date_format($this->created_at, "Y/m/d H:i")
        ];
    }
}
