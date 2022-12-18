<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserManageTrashedResource extends JsonResource
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
            'name'    =>  $this->name,
            'username'    =>  $this->username,
            'status' => ($this->status === 1) ? 'Active' : 'Disabled',
            'role_id' => ($this->role_id === 1) ? 'Subscriber' : 'Admin',
            'action'    => '<a href="javascript:void(0)" data-id="'.$this->id.'" class="restore btn btn-info btn-sm">Restore User</a> <a href="javascript:void(0)" data-id="'.$this->id.'" class="deletep btn btn-danger btn-sm">Delete Permanently</a>'

        ];
    }
}
