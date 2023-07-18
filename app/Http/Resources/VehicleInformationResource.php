<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleInformationResource extends JsonResource
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
            'car_license' => $this->license_plate,
            'car_front_photo' =>$this->front_image,
            'car_back_photo' => $this->back_image,
            'car_right_photo' => $this->right_image,
            'car_left_photo' => $this->left_image,
            'car_model' => $this-> car_model,
            'car_color' => $this->car_color,
            
        ];
    }
}
