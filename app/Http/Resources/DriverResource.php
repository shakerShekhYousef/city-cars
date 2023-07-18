<?php

namespace App\Http\Resources;

use App\Models\PaymentMethod;
use App\Models\CarModel;
use App\Models\DriverInformation;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
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
            'id' => $this->uuid,
            'country_code' => $this->country_code,
            'phone_number' => $this->phone_number,
            'name' => $this->name,
            'email' => $this->email,
            'image' => $this->image,
            'driver credit' => number_format($this->driver_credit, 2),

            'payment_methods' => $this->get_payment_methods(),

        ];
    }

    public function get_payment_methods()
    {
        $paymentMethods = PaymentMethodResource::collection(PaymentMethod::get());
        return $paymentMethods;
    }
 
    public function get_driver_information()
    {           

        $driverinformations = DriverInformationResource::collection(DriverInformation::get());
        return $driverinformations;
        }
}
