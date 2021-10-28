<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'familles'=> (ServiceFamillesResource::collection($this->whenLoaded('services'))),
            'father' => $this->father,
            'statut' => $this->statut,

            // 'created_at' =>Carbon::parse(  $this->created_at )->format('d/m/Y')
             'created_at' =>$this->created_at 
        ];
    }
}
