<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EstimateResource extends JsonResource
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
            'uuid' => $this->uuid,
            "duration_estimate" => $this->duration_estimate,
            "distance_estimate" => $this->distance_estimate,
            "estimated_value" => $this->estimated_value,
            "pickup" => [
                "name" => $this->pickup_name,
                "latitude" => $this->pickup_lat,
                "longitude" => $this->pickup_long,
                "eta" => $this->pickup_eta
            ],
            "dropoff" => [
                "name" => $this->dropoff_name,
                "latitude" => $this->dropoff_lat,
                "longitude" => $this->dropoff_long,
                "eta" => $this->dropoff_eta
            ]
            ];
    }
}
