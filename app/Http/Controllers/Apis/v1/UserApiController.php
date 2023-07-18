<?php

namespace App\Http\Controllers\Apis\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\CardResource;

use App\Http\Resources\UserResource;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\Notification;

use App\Models\PasswordReset;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid as UuidUuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Http\Resources\EstimateResource;
use App\Http\Resources\RideRequestResource;
use App\Models\CarType;
use App\Models\Estimate;
use App\Models\RideRequest;
use App\Models\Card;

use App\Models\VehicleInformation;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Client;
use Ramsey\Uuid\Nonstandard\Uuid;



class UserApiController extends Controller
{
    /*
        Defintion:
            user update prfile
        @Params:
            @param1 _  country_code
            @param2 _  phone
            @param3 _  email
            @param4 _  name
        @Response:
            data
    */
    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'country_code' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendResponse(false, "", $validator->getMessageBag(), 400);
        } else {
            try {
                // get authenticated user
                $user = auth("api")->user();
                // update data
                if ($user != null) {
                    // check duplicate email
                    $emailAlreadyUsed = User::where('uuid', '!=', $user->uuid)->where('email', $request->email)->count();
                    if ($emailAlreadyUsed > 0) {
                        return $this->sendResponse(false, "The email is already been taken", "", 400);
                    }

                    // check duplicate phone
                    $emailAlreadyUsed = User::where('uuid', '!=', $user->uuid)->where('phone_number', $request->phone)->count();
                    if ($emailAlreadyUsed > 0) {
                        return $this->sendResponse(false, "The phone is already been taken", "", 400);
                    }
                    $user->country_code = $request->country_code;
                    $user->phone_number = $request->phone;
                    $user->email = $request->email;
                    $user->name = $request->name;
                    $user->image = $request->image;
                    $user->save();

                    $token = $user->createToken("LaravelAuthApp")->accessToken;

                    //////// send response
                    $data = [
                        'token' => $token,
                        'user' => UserResource::make($user)
                    ];
                    return $this->sendResponse(true, "The process is completed successfully", $data, 200);
                } else {
                    return $this->sendResponse(false, "Unauthorized, Please login and try again", "", 401);
                }
            } catch (Exception $th) {
                return  $this->errorLog("UserApiController@update_profile", $th->getMessage());
            }
        }
    }

    /*
        Defintion:
            user change password
        @Params:
            @param1 _  current_password
            @param2 _  new_password

        @Response:
            message
    */
    public function change_password(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'current_password' => 'required',
            'new_password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendResponse(false, "", $validator->getMessageBag(), 400);
        } else {
            try {
                // get authenticated user
                $user = auth("api")->user();
                if ($user != null) {
                    // check current_password
                    if (!(Hash::check($request->get('current_password'), $user->password))) {
                        return $this->sendResponse(false, "Check your current password.", "", 400);
                    }
                    if (strcmp($request->get('current_password'), $request->get('new_password')) == 0) {
                        // Current password and new password same
                        return $this->sendResponse(false, "Please enter a new password which is not similar to current password.", "", 400);
                    }
                    // update data
                    $user->password = bcrypt($request->get('new_password'));
                    $user->save();
                    return $this->sendResponse(true, "The process is completed successfully", [], 200);
                } else {
                    return $this->sendResponse(false, "Unauthorized, Please login and try again", "", 401);
                }
            } catch (Exception $th) {
                return  $this->errorLog("UserApiController@change_password", $th->getMessage());
            }
        }
    }

    /*
        Defintion:
            user reset password
        @Params:
            @param1 _  email
        @Response:
            message
    */
    public function reset_password(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(false, "", $validator->getMessageBag(), 400);
        } else {
            try {
                $user = User::where('email', $request->email)->first();
                if ($user == null) {
                    return $this->sendResponse(false, "Email not found", "", 400);
                }
                $token = bin2hex(random_bytes(40));
                $link = config('app.url') . '/user/password_reset/' .  $token;
                PasswordReset::create([
                    'email' => $request->email,
                    'token' => $token
                ]);

                $details = [
                    'title' => 'Password reset link',
                    'body' => $link,
                ];

                \Mail::to($user->email)->send(new \App\Mail\MyTestMail($details));

                return $this->sendResponse(true, "The process is completed successfully", "", 200);
            } catch (Exception $th) {
                return  $this->errorLog("UserApiController@reset_password", $th->getMessage());
            }
        }
    }

    /*
        Defintion:
            user reset image
        @Params:
            @param1 _  image
        @Response:
            message
    */
    public function reset_image(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'image' => 'required|image|mimes:png,jpg'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(false, "", $validator->getMessageBag(), 400);
        } else {
            try {
                // get authenticated user
                $user = auth("api")->user();
                // update image
                if ($user != null) {
                    if (File::exists($user->image)) {
                        File::delete($user->image);
                    }
                    $path =  $request->image->store('storage/users/images');
                    $user->image = $path;
                    $user->update();

                    //////// send response
                    $data = [
                        'image_path' => $path
                    ];
                    return $this->sendResponse(true, "The process is completed successfully", $data, 200);
                } else {
                    return $this->sendResponse(false, "Unauthorized, Please login and try again", "", 401);
                }
            } catch (Exception $th) {
                return  $this->errorLog("UserApiController@reset_image", $th->getMessage());
            }
        }
    }

    /*
        Defintion:
            get all payment methods
        @Params:
        @Response:
            data
    */
    public function payment_methods()
    {
        try {
            // get authenticated user
            $user = auth("api")->user();
            if ($user != null) {
                //////// send response
                $data = [
                    'payment_methods' => PaymentMethodResource::collection(PaymentMethod::get()),
                ];
                return $this->sendResponse(true, "The process is completed successfully", $data, 200);
            } else {
                return $this->sendResponse(false, "Unauthorized, Please login and try again", "", 401);
            }
        } catch (Exception $th) {
            return  $this->errorLog("UserApiController@payment_methods", $th->getMessage());
        }
    }

    /*
        Defintion:
            exist Phon Email
        @Params:
            @param1 _  phone
        @Response:
            data
    */
    public function existPhonEmail(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendResponse(false, "", $validator->getMessageBag(), 400);
        } else {
            try {
                if ($request->email != null) {
                    $emailOrPhone = User::where('email', $request->email)->orWhere('phone_number', $request->phone)->first();
                    if ($emailOrPhone == null) {
                        return $this->sendResponse(true, "Email and phone are not found", "", 200);
                    } else {
                        return $this->sendResponse(true, "Email or phone is found", "", 400);
                    }
                } else {
                    $phone = User::where('phone_number', $request->phone)->first();
                    if ($phone == null) {
                        return $this->sendResponse(true, "Phone is not found", "", 200);
                    } else {
                        return $this->sendResponse(true, "Phone already found", "", 400);
                    }
                }
            } catch (Exception $th) {
                return  $this->errorLog("UserApiController@existPhonEmail", $th->getMessage());
            }
        }
    }

    /*
        Defintion:
            get notifications
        @Param:
            @param _  page

        @Response:
            data
    */
    public function get_notification()
    {
        try {
            $notifications = Notification::where('receiver', Auth::user()->uuid)->orderBy('created_at', 'desc')->paginate(10);
            if (count($notifications) == 0) {
                return $this->sendResponse(true, 'There are no notifications', "", 400);
            } else {
                $data = [];
                foreach ($notifications as $notification) {
                    $sender = User::where('uuid', $notification->sender)->first();
                    $receiver = User::where('uuid', $notification->receiver)->first();
                    $requests = RideRequest::with('driverObj')->with('carTypeObj')->with('user')->with('estimate')->where('uuid', $notification->request)->first();
                    if ($requests != null) {
                        $vehicle = $requests->driverObj != null ? VehicleInformation::where('driver_id', $requests->driverObj->uuid)->first() : null;

                        $sender_obj = null;
                        if (!is_null($sender)) {
                            $sender_obj = $sender;
                        }

                        $receiver_obj = null;
                        if (!is_null($receiver)) {
                            $receiver_obj = $receiver;
                        }


                        $data[] = [
                            'title' => $notification->title,
                            'body' => $notification->body,
                            'sender' => $sender_obj,
                            'receiver' => $receiver_obj,
                            "notification_type" => $notification->notification_type,
                            'request' => [
                                'ride_request' => [
                                    'id' => $requests->uuid,
                                    'status' => $requests->status,
                                    'car_type_image' => $requests != null ? ($requests->carTypeObj != null ? $requests->carTypeObj->image : null) : null,
                                    'driver' => $requests != null && $requests->driverObj != null ? [
                                        'phone' => $requests->driverObj->phone,
                                        'image' => $requests->driverObj->image,
                                        'name' => $requests->driverObj->name,
                                    ] : null,
                                    'location' => $requests != null ? [
                                        'latitude' => $requests->user->lat,
                                        'longitude' => $requests->user->long
                                    ] : null,
                                    'vehicle' => $vehicle != null ? [
                                        'model' => $vehicle->car_model,
                                        'license_plate' => $vehicle->license_plate,
                                        'image' => $vehicle->front_image,
                                    ] : null,
                                ],
                                'estimate' => [
                                    'id' => $requests->estimate->first()->uuid,
                                    'duration_estimate' => $requests->estimate->first()->duration_estimate,
                                    'distance_estimate' => $requests->estimate->first()->distance_estimate,
                                    'estimated_value' => $requests->estimate->first()->estimated_value,
                                    'pickup' => [
                                        'name' => $requests->estimate->first()->pickup_name,
                                        'latitude' => $requests->estimate->first()->pickup_lat,
                                        'longitude' => $requests->estimate->first()->pickup_long,
                                        'eta' => $requests->estimate->first()->pickup_eta,
                                    ],
                                    'dropoff' => [
                                        'name' => $requests->estimate->first()->dropoff_name,
                                        'latitude' => $requests->estimate->first()->dropoff_lat,
                                        'longitude' => $requests->estimate->first()->dropoff_long,
                                        'eta' => $requests->estimate->first()->dropoff_eta,
                                    ]
                                ]
                            ],
                        ];
                    } else {
                        $sender_obj = null;
                        if (!is_null($sender)) {
                            $sender_obj = $sender;
                        }

                        $receiver_obj = null;
                        if (!is_null($receiver)) {
                            $receiver_obj = $receiver;
                        }

                        $data[] = [
                            'title' => $notification->title,
                            'body' => $notification->body,
                            'sender' => $sender_obj,
                            'receiver' => $receiver_obj,
                            "notification_type" => $notification->notification_type,
                        ];
                    }
                }
                $notification1 = [
                    'current_page' => $notifications->currentPage(),
                    'last_page' => $notifications->lastPage(),
                    'notification' => $data
                ];
                return $this->sendResponse(true, 'The process is completed successfully', $notification1, 200);
            }
        } catch (Exception $th) {
            return  $this->errorLog("UserApiController@get_notification", $th->getMessage());
        }
    }

    /*
        Defintion:
            save device token
        @Param:
        @Response:
            data
    */
    public function save_token(Request $request)
    {
        try {
            $validator = Validator::make($request->toArray(), [
                'device_token' => 'required|string'
            ]);
            if ($validator->fails()) {
                return $this->sendResponse(false, "", $validator->getMessageBag(), 400);
            }
            User::where('uuid', Auth::user()->uuid)->update(['device_token' => $request->device_token]);
            return $this->sendResponse(true, 'The process is completed successfully', '', 200);
        } catch (Exception $th) {
            return  $this->errorLog("UserApiController@save_token", $th->getMessage());
        }
    }

    /*
        Defintion:
            delete device token
        @Param:
        @Response:
            data
    */
    public function remove_token(Request $request)
    {
        try {
            User::where('uuid', Auth::user()->uuid)->update(['device_token' => null]);
            return $this->sendResponse(true, 'The process is completed successfully', '', 200);
        } catch (Exception $th) {
            return  $this->errorLog("UserApiController@remove_token", $th->getMessage());
        }
    }

    /*
        Defintion:
            add language
        @Params:
            @param1 _  language
        @Response:
            message
    */

    public function add_language(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'language' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(false, "", $validator->getMessageBag(), 400);
        } else {
            try {
                // get authenticated user
                $user = auth("api")->user();
                if ($user != null) {
                    $user->language = $request->language;
                    $user->save();
                    $data = [
                        'language' => $user->language
                    ];
                    return $this->sendResponse(true, "The process is completed successfully", $data, 200);
                } else {
                    return $this->sendResponse(false, "Unauthorized, Please login and try again", "", 401);
                }
            } catch (Exception $th) {
                return  $this->errorLog("UserApiController@add_language", $th->getMessage());
            }
        }
    }
}
