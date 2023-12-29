<?php

namespace App\Http\Resources\Security;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'is_admin' => $this->is_admin == 1 ? true : false,
            'is_active' => $this->is_active == 1 ? true : false,
            'acl_group_id' => $this->acl_group_id,
            // 'company' => Company::find($this->companies->setVisible('company_id')),
            'created_at'=>!empty($this->created_at) ? date('d-m-Y H:m:i', strtotime($this->created_at)) : '',
            'updated_at'=>!empty($this->updated_at) ? date('d-m-Y H:m:i', strtotime($this->updated_at)) : ''
        ];
    }
}
