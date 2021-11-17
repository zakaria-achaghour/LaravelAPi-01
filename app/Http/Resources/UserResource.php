<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id ,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'username' => $this->username,
            'email' => $this->email,
            'gender' => $this->gender,
             'contact' => $this->When(null,$this->contact),
            'roles' =>   (UserRoleResource::collection($this->whenLoaded('roles'))),
            'familles' =>   (UserFamilleResource::collection($this->whenLoaded('familles'))),

        ];
    }
}
