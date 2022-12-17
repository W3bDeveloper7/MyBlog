<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class BlogIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'    =>  $this->id,
            'title'    =>  $this->title,
            'blog_content'    =>  Str::limit($this->blog_content, 1),
            'image' => '<image src="'.$this->image.'">',
            'published_at' => '',
            'status' => $this->status,
            'user_id' => $this->user_id,

        ];
    }
}
