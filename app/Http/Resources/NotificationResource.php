<?php

namespace App\Http\Resources;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'title' => $this->title,
            'body' => $this->body,
            'sender' => $this-> get_sender(),
            'receiver' => $this->get_receiver(),
            'notification_type' => $this->notification_type,
            // 'request' => $this->request,
   
        ];
    }
    
    public function get_sender()
    {  
          $user = auth()->user();
          $user = user::where('uuid', $user->uuid)->first();
        return [
                'id'=> $user->uuid,
                'country_code'=>$user->country_code,
                'phone'=> $user->phone_number,
                'name'=> $user->name,
                'email'=> $user->email,
                'image'=> $user->image,
               
        ];
    }
    public function get_receiver()
    {  
   
          $user = user::where('uuid', $user->uuid)->first();
        return [
                'id'=> $user->uuid,
                'country_code'=>$user->country_code,
                'phone'=> $user->phone_number,
                'name'=> $user->name,
                'email'=> $user->email,
                'image'=> $user->image,
               
        ];
    }
}
