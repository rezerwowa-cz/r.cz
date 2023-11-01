<?php

namespace App\Http\Resources;

use App\Models\ServiceOrder;
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
        /** @var ServiceOrder $this */
        return [
            'id' => $this->id,
            'service' => new ServiceResource($this->service),
            'price' => (string) money($this->price, $this->currency, true),
            'datetime' => $this->service_date->format('d-m-Y H:i'),
            'status' => $this->status,
        ];
    }
}
