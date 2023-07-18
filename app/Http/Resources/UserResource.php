<?php

namespace App\Http\Resources;

use App\Models\PaymentMethod;
use App\Models\CarModel;

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
            'id' => $this->uuid,
            'country_code' => $this->country_code,
            'phone_number' => $this->phone_number,
            'name' => $this->name,
            'email' => $this->email,
            'image' => $this->image,
            'payment_methods' => $this->get_payment_methods()
        ];
    }

    public function get_payment_methods()
    {
        $paymentMethods = PaymentMethodResource::collection(PaymentMethod::get());
        return $paymentMethods;
    }
   
}
