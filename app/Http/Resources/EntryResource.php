<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EntryResource extends JsonResource
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
            'product' => ( new EntryProductResource($this->whenLoaded('product'))),
            'unity' => ( new UnityResource($this->whenLoaded('unity'))),
            'currency' => ( new CurrencyResource($this->whenLoaded('currency'))),
            'fournisseur' => ( new EntryFournisseurResource($this->whenLoaded('fournisseur'))),
            'bon_commande' => $this->bon_commande,
            'date_peremption' => $this->date_peremption,
            'date_reception' => $this->date_reception,
            'lot_fournisseur' => $this->lot_fournisseur,
             'cofe' => $this->When(null,$this->cofe),
             'qte' => $this->qte,
             'prix_unitaire' => $this->prix_unitaire,
             'taux_change' => $this->taux_change,
             'prix_unitaire' => $this->prix_unitaire,
        ];
    }
}  