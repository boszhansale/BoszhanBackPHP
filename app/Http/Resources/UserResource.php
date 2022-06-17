<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'phone' => $this->phone,
            'login' => $this->login,
            'id_1c' => $this->id_1c,
            'winning_access' => $this->winning_access,
            'payout_access' => $this->payout_access,
            'status' => $this->status,
            'roles' => $this->roles,
            'driver' => $this->driver,
        ];
    }
}
