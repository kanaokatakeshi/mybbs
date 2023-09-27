<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $posted_at = new Carbon($this->created_at);
        return [
            'data' => [
                'post_id' => $this->id,
                'image' => $this->image,
                'post_title' => $this->title,
                'post_content'    => $this->content,
                'post_at' => $posted_at->format('Y/m/d H:i'),
                'post_by' => $this->user->name,
                'post_comment_count' => $this->comments->count(),
            ],
            'links' => [
                'self' => url('/post/' . $this->id),
            ]
        ];
    }
}
