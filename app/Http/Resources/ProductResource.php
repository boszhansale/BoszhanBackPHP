<?php

namespace App\Http\Resources;

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
            'id' => $this->id,
            'name' => $this->name,
            'id_1c' => $this->id_1c,
            'discount' => $this->discount,
            'enabled' => $this->enabled,
            'price_type' => $this->priceType,
            'payment_type' => $this->paymentType,
            'debt' => 0,
            'delay' => 0,
        ];
    }
}
