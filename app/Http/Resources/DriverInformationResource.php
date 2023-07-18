<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverInformationResource extends JsonResource
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
            'drive_license_front_photo' => $this->drive_license_front_photo,
            'drive_license_back_photo' => $this->drive_license_back_photo,
             'no_criminal_record' => $this->no_criminal_record,
            'health_certificate' => $this->health_certificate,
            'id_photo' => $this->id_photo,
        ];
    }
}
