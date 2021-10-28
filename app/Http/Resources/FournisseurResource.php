<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FournisseurResource extends JsonResource
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
            'sage' =>  $this->When(null,$this->sage),
            'name' => $this->name,
            'statut' => $this->statut,
            'motif' => $this->When(null,$this->motif),
            // 'created_at' =>Carbon::parse(  $this->created_at )->format('d/m/Y')
             'created_at' =>$this->created_at 
        ];
    }
}
