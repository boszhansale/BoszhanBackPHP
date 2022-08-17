<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'status' => $this->status,
            'store' => $this->store,
            'salesrep' => $this->salesrep,
            'driver' => $this->driver,
            'mobile_id' => $this->mobile_id,
            'payment_type' => $this->paymentType,
            'payment_status' => $this->paymentStatus,
            'payment_full' => $this->payment_full,
            'payment_partial' => $this->payment_partial,
            'winning_name' => $this->winning_name,
            'winning_phone' => $this->winning_phone,
            'winning_status' => $this->winning_status,
            'delivery_date' => $this->delivery_date,
            'delivered_date' => $this->delivered_date,
            'created_at' => $this->created_at,
            'purchase_price' => $this->purchase_price,
            'return_price' => $this->return_price,
            'bonus_game_sum' => $this->bonusGames()->exists() ? $this->bonusGames()->sum('win'):0,
            'baskets' => $this->baskets()
                ->with('product')
                ->join('products','products.id','baskets.product_id')
                ->orderBy('baskets.type')
                ->orderBy('products.measure','desc')
                ->select('baskets.*')
                ->get(),
        ];
    }
}
