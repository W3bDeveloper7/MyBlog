<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class UserManageResource extends JsonResource
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
            'name' => $this->name,
            'username' => $this->username,
            'status' => ($this->status === 1) ? 'Active' : 'Disabled',
            'role_id' => ($this->role_id === 1) ? 'Subscriber' : 'Admin',
            'action' => '<a href="javascript:void(0)" data-id="'.$this->id.'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" data-id="'.$this->id.'" class="delete btn btn-danger btn-sm">Delete</a>',

        ];
    }
}
