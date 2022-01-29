<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SortieResource extends JsonResource
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
            'qte' => $this->qte,
            'date_consommation' => $this->date_consommation,
            'receiver' =>( new ReceiverResource($this->whenLoaded('receiver'))),
            'destination' => ( new DestinationResource($this->whenLoaded('destination'))),
            'observation' => $this->When(null,$this->observation),
        ];
    }
}
