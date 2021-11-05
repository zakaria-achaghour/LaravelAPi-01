<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductFourniseursResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return join(' , ',[
        //     'label' => $this->name,
        //  ]);
        return [
            
            'value' => $this->id,
            'label' => $this->name
        ];
    }
}
