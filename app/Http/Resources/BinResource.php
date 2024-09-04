<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BinResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'bin' => $this->bin,
            'type' => $this->type,
            'brand' => $this->brand,
            'bank' => $this->bank,
            'country' => $this->country,
            'provider' => $this->provider,
        ];
    }
}