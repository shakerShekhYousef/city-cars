<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RideRequestResource extends JsonResource
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
            'ride_request' => [
                'uuid' => $this->uuid,
                'status' => $this->status,
                'car_type_image' => $this->carTypeObj != null ? $this->carTypeObj->image : null,
                'front_image'=>$this->driverObj != null ? $this->driverObj->vehicleInformation->front_image : null,

                'driver' => [
                    'uuid'=>$this->driverObj != null ? $this->driverObj->uuid : null,
                    'name' => $this->driverObj != null ? $this->driverObj->name : null,
                    'country_code' => $this->driverObj != null ? $this->driverObj->country_code : null,
                    'phone' => $this->driverObj != null ? $this->driverObj->phone_number : null,
                    'image' => $this->driverObj != null ? $this->driverObj->image : null,
                    'rate' => $this->driverObj != null ? $this->driverObj->rate : null,

                ],
                'user' => [
                    'uuid'=>$this->userObj != null ? $this->userObj->uuid : null,
                    'name' => $this->userObj != null ? $this->userObj->name : null,
                    'country_code' => $this->userObj != null ? $this->userObj->country_code : null,
                    'phone' => $this->userObj != null ? $this->userObj->phone_number : null,

                ],
                'location' => [
                    'latitude' => $this->driverObj != null ? $this->driverObj->lat : null,
                    'longitude' => $this->driverObj != null ?  $this->driverObj->long : null,
                ],
                'vehicle' => [
                    'model' => $this->driverObj != null ? $this->driverObj->vehicleInformation->carModel->name : null,
                    'license_plate' => $this->driverObj != null ? $this->driverObj->vehicleInformation->license_plate : null
                ]
            ],
            'estimate' => new EstimateResource($this->estimate->first())
        ];
    }
}
