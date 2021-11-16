<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'sage' => $this->sage,
            'lot_fournisseur' => $this->lot_fournisseur,
            'date_peremption' => $this->date_peremption,
            'famille' => ( new ProductFamilleResource($this->whenLoaded('famille'))),
            'unity' => ( new UnityResource($this->whenLoaded('unity'))),
            'fournisseurs' => (ProductFourniseursResource::collection($this->whenLoaded('fournisseurs'))),
            'entries' => (EntryResource::collection($this->whenLoaded('entries'))),

            'prix' => $this->prix_moyen,
            'max' => $this->max,
            'min' => $this->min,
            'statut' => $this->statut,
             'created_at' =>Carbon::parse($this->created_at )->format('d/m/Y')
            
        ];
    }
}
