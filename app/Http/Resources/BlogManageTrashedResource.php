<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use JsonSerializable;

class BlogManageTrashedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'blog_content' => Str::limit($this->blog_content, 1),
            'image' => (filter_var($this->image,
                FILTER_VALIDATE_URL)) ? '<image class="img-thumbnail" src="'.$this->image.'">' : '<image class="img-thumbnail" src="'.url('images').'/'.$this->image.'">',
            'published_at' => Carbon::parse($this->published_at)->format('Y-m-d'),
            'status' => ($this->status === 1) ? 'Active' : 'Disabled',
            'user_id' => $this->user_id,
            'action' => '
    <a href="javascript:void(0)" data-id="'.$this->id.'" class="restore btn btn-info btn-sm">Restore Blog</a> <a href="javascript:void(0)" data-id="'.$this->id.'" class="deletep btn btn-danger btn-sm">Delete Permanently</a>
',

        ];
    }
}
