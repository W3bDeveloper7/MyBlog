<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class BlogManageResource extends JsonResource
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
            'image' => (filter_var($this->image, FILTER_VALIDATE_URL)) ? '<image class="card-img" src="'.$this->image.'">' : '<image class="card-img" src="'.url('images').'/'.$this->image.'">',
            'published_at' => \Carbon\Carbon::parse($this->published_at)->format('Y-m-d'),
            'status' => ($this->status === 1) ? 'Active' : 'Disabled',
            'user_id' => $this->user_id,
            'action' => '<div class="btn-group" role="group" aria-label="Basic example">
    <a href="javascript:void(0)" role="button" data-id="'.$this->id.'" class="edit btn btn-info">Edit</a>
    <a href="javascript:void(0)" role="button" data-id="'.$this->id.'" class="delete btn btn-danger">Delete</a>
</div>',

        ];
    }
}
