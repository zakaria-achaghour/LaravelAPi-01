<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'sage' =>  $this->When($this->sage!="",$this->sage,""),
            'name' => $this->name,
            'products' => (FournisseurProductResource::collection($this->whenLoaded('products'))),
            'statut' => $this->statut,
            'motif' => $this->When($this->motif!="",$this->motif,""),
             'created_at' =>Carbon::parse(  $this->created_at )->format('d/m/Y')
            //  'created_at' =>$this->created_at 
        ];
    }
}
