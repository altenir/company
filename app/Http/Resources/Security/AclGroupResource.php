<?php

namespace App\Http\Resources\Security;

use Illuminate\Http\Resources\Json\JsonResource;

class AclGroupResource extends JsonResource
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
            'id' => $this->id,
            'description' => $this->description,
            'is_active' => $this->is_active == 1 ? true : false,
            
            'created_at'=>!empty($this->created_at) ? date('d-m-Y H:m:i', strtotime($this->created_at)) : '',
            'updated_at'=>!empty($this->updated_at) ? date('d-m-Y H:m:i', strtotime($this->updated_at)) : '',
        ];
    }
}
