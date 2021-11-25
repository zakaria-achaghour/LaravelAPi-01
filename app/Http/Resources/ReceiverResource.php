<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceiverResource extends JsonResource
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
            'id' => $this->id ,
            'name' => $this->name,
            'statut' => $this->statut,
            'service' => ( new FamilleServiceResource($this->whenLoaded('service'))),
             'created_at' =>$this->created_at 
        ];
    }
}