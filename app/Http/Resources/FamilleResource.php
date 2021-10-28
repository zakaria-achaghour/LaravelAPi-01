<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FamilleResource extends JsonResource
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
            'lot_fournisseur' => $this->lot_fournisseur,
            'date_peremption' => $this->date_peremption,
            'inventaire' => $this->inventaire,
            'service' => ( new FamilleServiceResource($this->whenLoaded('service'))),
            // 'created_at' =>Carbon::parse(  $this->created_at )->format('d/m/Y')
             'created_at' =>$this->created_at 
        ];
    }
}
