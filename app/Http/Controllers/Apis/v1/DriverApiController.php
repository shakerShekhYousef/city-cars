<?php

namespace App\Http\Controllers\Apis\v1;

use App\Events\accept_request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CarModelResource;
use App\Http\Resources\DriverResource;
use App\Http\Resources\PaymentMethodResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\DriverInformationResource;
use App\Http\Resources\VehicleInformationResource;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\PaymentMethod;
use App\Models\CarType;
use App\Models\DriverInformation;
use App\Models\Estimate;
use Illuminate\Support\Facades\Auth;
use App\Models\RideRequest;
use App\Models\Card;
use App\Http\Resources\CardResource;

use App\Models\VehicleInformation;
use App\Models\User;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid as UuidUuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CarModel;
use App\Models\DashboardData;
use App\Models\home_data;
use App\Models\Notification;
use App\Models\Review;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DriverApiController extends Controller
{
    /*
        Defintion:
            get app data
        @Response:
            data
    */
    public function app_data()
    {
        try {

            //////// send response
            $data = [
                'car_models' => CarModelResource::collection(CarModel::get()),

            ];
            return $this->sendResponse(true, "The process is completed successfully", $data, 200);
        } catch (Exception $th) {
            return  $this->errorLog("DriverApiController@app_data", $th->getMessage());
        }
    }
    /*
        Defintion:
            upload multiple files to server and get its links
        @Param:
            @param1_ documents[]
            @param2_ document_type

        @Response:
            data
    */

    public function upload_documents(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'documents' => 'required',
            'documents.*' => 'required|file|mimes:jpeg,png,jpg',
            'document_type' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(false, "", $validator->getMessageBag(), 400);
        } else {
            try {
                // get authenticated user
                $links = [];
                /// check files type
                if ($request->document_type == "drive_license") {
                    $store_path = "storage/documents/driver/drive_licenses";
                } else if ($request->document_type == "car_license") {
                    $store_path = "storage/documents/driver/cars_licenses";
                } else if ($request->document_type == "car_images") {
                    $store_path = "storage/documents/driver/cars_images";
                } else if ($request->document_type == "no_criminal") {
                    $store_path = "storage/documents/driver/no_criminal";
                } else if ($request->document_type == "health_certificate") {
                    $store_path = "storage/documents/driver/health_certificates";
                } else if ($request->document_type == "id_photo") {
                    $store_path = "storage/documents/driver/ids";
                } else if ($request->document_type == "image") {
                    $store_path = "storage/documents/driver/images";
                } else if ($request->document_type == "other_driver") {
                    $store_path = "storage/documents/driver/others";
                }
                // loop through docs and save
                foreach ($request->documents as $document) {
                    $links[] = $document->store($store_path);
                }

                //////// send response
                $data = [
                    "links" =>
                    $links
                ];
                return $this->sendResponse(true, "The process is completed successfully", $data, 200);
                // $user = auth("api")->user();
                // if ($user != null) {
                // } else {
                //     return $this->sendResponse(false, "Unauthorized, Please login and try again", "", 401);
                // }
            } catch (Exception $th) {
                return  $this->errorLog("DriverApiController@upload_documents", $th->getMessage());
            }
        }
    }
    /*
        Defintion:
           register a new driver
        @Params:
            @param1 _  name
            @param2 _  country_code
            @param3 _  phone_number
            @param4 _  email
            @param5 _  password
            @param6 _  image
            @param7 _ drive_license_front_photo
            @param8_ drive_license_back_photo
            @param9_ car_license
            @param10_ car_front_photo
            @param11_ car_back_photo
            @param12_ car_right_photo
            @param13_ car_left_photo
            @param14_ car_model_id
            @param15_ car_color
            @param16_ no_criminal_record
            @param17_ health_certificate
            @param18_ hid_photo

        @Response:
            data
    */

    public function driver_sign_up(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'name' => 'required',
            'country_code' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'image' => 'required',
            'drive_license_front_photo' => 'required',
            'drive_license_back_photo' => 'required',
            'car_license' => 'required',
            'car_front_photo' => 'required',
            'car_back_photo' => 'required',
            'car_right_photo' => 'required',
            'car_left_photo' => 'required',
            'car_model_id' => 'required',
            'car_color' => 'required',
            'no_criminal_record' => 'required',
            'health_certificate' => 'required',
            'id_photo' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendResponse(false, "", $validator->getMessageBag(), 400);
        }

        $email = User::where('email', $request->email)->count();
        if ($email > 0) {
            return $this->sendResponse(false, "", "The email is already been taken", 400);
        }
        $phone_number = User::where('phone_number', $request->phone_number)->count();
        if ($phone_number > 0) {
            return $this->sendResponse(false, "", "The phone number is already been taken", 400);
        }
        try {
            $home_data = home_data::find(1);
            $user = User::create([
                'uuid' => UuidUuid::uuid4()->toString(),
                'name' => $request->name,
                'country_code' => $request->country_code,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'Driver',
                'image' => $request->image,
            ]);
            $driver_information = DriverInformation::create([
                'uuid' => UuidUuid::uuid4()->toString(),
                'driver_id' => $user->uuid,
                'drive_license_front_photo' => $request->drive_license_front_photo,
                'drive_license_back_photo' => $request->drive_license_back_photo,
                'no_criminal_record' => $request->no_criminal_record,
                'health_certificate' => $request->health_certificate,
                'id_photo' => $request->id_photo
            ]);
            $vehicle_information = VehicleInformation::create([
                'uuid' => UuidUuid::uuid4()->toString(),
                'car_model' =>  $request->car_model_id,
                'driver_id' => $user->uuid,
                'front_image' => $request->car_front_photo,
                'back_image' => $request->car_back_photo,
                'right_image' => $request->car_right_photo,
                'left_image' => $request->car_left_photo,
                'car_color' => $request->car_color,
                'license_plate' => $request->car_license
            ]);
            $tokenResult =  $user->createToken('authToken');
            $response = [
                'success' => "true",
                'message' => "User created successfully",
                "data" => array(
                    'token' =>  $tokenResult->accessToken,
                    'user' =>
                    DriverResource::make($user),
                    'drive_license_front_photo' => $request->drive_license_front_photo,
                    'drive_license_back_photo' => $request->drive_license_back_photo,
                    'car_license' => $request->car_license,
                    'car_front_photo' => $request->car_front_photo,
                    'car_back_photo' => $request->car_back_photo,
                    'car_right_photo' => $request->car_right_photo,
                    'car_left_photo' => $request->car_left_photo,
                    'car_model_id' =>  $request->car_model_id,
                    'car_color' => $request->car_color,
                    'no_criminal_record' => $request->no_criminal_record,
                    'health_certificate' => $request->health_certificate,
                    'id_photo' => $request->id_photo,
                    'home data' => ($home_data) ? $home_data : null
                )
            ];

            return response($response, 201);
        } catch (Exception $th) {
            return  $this->errorLog("DriverApiController@driver_sign_up", $th->getMessage());
        }
    }

    /*
        Defintion:
            driver Login request using email and password.
        @Params:
            @param1 _  email
            @param2 _  password
        @Response:
            data
    */
    public function driver_login(Request $request)
    {
        try {
            $validator = Validator::make($request->toArray(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->sendResponse(false, "", $validator->getMessageBag(), 400);
            }

            $user = [
                'email' => $request->email,
                'password' => $request->password
            ];
            if (auth()->attempt($user)) {
                $user = User::where('email', $request->email)->first();
                if ($user->status == 0) {
                    return $this->sendResponse(false, "Your account is blocked.", "", 400);
                }
                if (!$user->user_verified) {
                    return $this->sendResponse(false, "Unverified driver", "", 400);
                }
                $driver_information = DriverInformation::where('driver_id', $user->uuid)->first();
                $vehicle_information = VehicleInformation::where('driver_id', $user->uuid)->first();
                $token = $user->createToken('LaravelAuthApp')->accessToken;
                $home_data = home_data::find(1);
                $data = [
                    'token' => $token,
                    'user' => DriverResource::make($user),
                    'drive_license_front_photo' => $driver_information != null ? $driver_information->drive_license_front_photo : null,
                    'drive_license_back_photo' => $driver_information != null ? $driver_information->drive_license_back_photo : null,
                    'car_license' => $vehicle_information != null ? $vehicle_information->license_plate : null,
                    'car_front_photo' => $vehicle_information != null ? $vehicle_information->front_image : null,
                    'car_back_photo' => $vehicle_information != null ? $vehicle_information->back_image : null,
                    'car_right_photo' => $vehicle_information != null ? $vehicle_information->right_image : null,
                    'car_left_photo' => $vehicle_information != null ? $vehicle_information->left_image : null,
                    'car_model' =>  $vehicle_information != null ? $vehicle_information->car_model : null,
                    'car_color' => $vehicle_information != null ? $vehicle_information->car_color : null,
                    'no_criminal_record' => $driver_information != null ? $driver_information->no_criminal_record : null,
                    'health_certificate' => $driver_information != null ? $driver_information->health_certificate : null,
                    'id_photo' => $driver_information != null ? $driver_information->id_photo : null,
                    'home data' => ($home_data) ? $home_data : null
                ];
                return $this->sendResponse(true, "The process is completed successfully", $data, 200);
            } else {
                return $this->sendResponse(false, "Invalid email/password", "", 400);
            }
        } catch (Exception $th) {
            return  $this->errorLog("DriverApiController@driver_login", $th->getMessage());
        }
    }

    /*
        Defintion:
            get all pending requests.
        @Params:
        @Response:
            data
    */
    public function get_requests(Request $request)
    {
        try {
            $user1 = User::find(Auth::user()->uuid)->vehicleInformation;

            if (!$user1 || !$user1->carModel) {
                return $this->sendResponse(false, "No driver is found", "", 400);
            } else {
                $user2 = $user1->carModel->car_type_obj;
                $driver_location = User::select('long', 'lat')->where('uuid', Auth::user()->uuid)->first();
                if ($driver_location->lat == null || $driver_location->long == null) {
                    return $this->sendResponse(false, "Invalid driver coordinates", "", 400);
                }

                $estimate = Estimate::whereRaw("6371 * acos( cos( radians(" . $driver_location->lat . ") ) * cos( radians( estimates.pickup_lat) ) * cos( radians( estimates.pickup_long ) - radians(" . $driver_location->long . ") ) + sin( radians(" . $driver_location->lat . ") ) * sin( radians( estimates.pickup_lat ) ) ) < 200  ")
                    ->join('ride_requests', 'ride_requests.estimate_id', '=', 'estimates.uuid')
                    ->where('estimates.car_type_id', $user2->uuid)
                    ->where('ride_requests.status', '=', 'pending')
                    ->paginate(10);

                if (!$estimate->items()) {
                    return $this->sendResponse(false, "No request is found", "", 400);
                } else {

                    $data1 = [];
                    foreach ($estimate as $es) {
                        $user = User::where('uuid', $es->user_id)->get();
                        $driver = DriverInformation::where('uuid', $es->driver_id)->get();
                        $vehicle = VehicleInformation::where('driver_id', $es->driver_id)->get();
                        $data1[] = [
                            'ride_request' =>
                            [
                                'uuid' => $es->uuid,
                                'status' => $es->status,
                                'car_type_image' => $user2->image,
                                'driver' => $driver->first(),
                                'user' =>
                                [
                                    'phone' => $user->first()->phone_number,
                                    'image' => $user->first()->image,
                                    'name' => $user->first()->name,
                                ],
                                'location' => [
                                    'latitude' => $user->first()->lat,
                                    'longitude' => $user->first()->long,

                                ],
                                'vehicle' => $vehicle->first(),
                            ],
                            'estimates' => [
                                'id' => $es->estimate_id,
                                'duration_estimate' => $es->duration_estimate,
                                'distance_estimate' => $es->distance_estimate,
                                'estimated_value' => $es->estimated_value,
                                'pickup' => [
                                    'name' => $es->pickup_name,
                                    'latitude' => $es->pickup_lat,
                                    'longitude' => $es->pickup_long,
                                    'eta' => $es->pickup_eta,
                                ],
                                'dropoff' => [
                                    'name' => $es->dropoff_name,
                                    'latitude' => $es->dropoff_lat,
                                    'longitude' => $es->dropoff_long,
                                    'eta' => $es->dropoff_eta,
                                ]
                            ]
                        ];
                    }
                    $panding = [
                        'current_page' => $estimate->currentPage(),
                        'last_page' => $estimate->lastPage(),
                        'pending_requests' => $data1
                    ];
                    return $this->sendResponse(true, 'The process is completed successfully', $panding, 200);
                }
            }
        } catch (Exception $th) {
            return  $this->errorLog("DriverApiController@get_requests", $th->getMessage());
        }
    }

    /*
        Defintion:
            accept a request
        @Params:
            @param1 _  (uuid) request_id

        @Response:
            message
    */
    public function accept_request(Request $request)
    {
        try {
            $driver_id = Auth::user()->uuid;
            $rider = RideRequest::where("driver_id", $driver_id)->where('status', '!=', 'completed')->get();

            if (count($rider) == 0) {
                $rider2 = RideRequest::where('uuid', $request->request_id)->first();
                if ($rider2 == null) {
                    return $this->sendResponse(true, 'Request not found', "", 400);
                }
                if ($rider2->driver_id == null && $rider2->status == 'pending') {

                    /////////////////////////// driver balance ///////////////////////////
                    // get trip cost
                    $estimate = Estimate::where('uuid', $rider2->estimate_id)->first();
                    $trip_price =  $estimate->estimated_value;
                    $trip_price = $trip_price != null ? floatval($trip_price) : 0;
                    // get driver balance
                    $driver_balance = Auth::user()->driver_credit;
                    // get discount percentage
                    $discount_value = DashboardData::first()->percentage;
                    $discount_value = $discount_value != null ? floatval($discount_value) : 0;

                    // get trip discount value
                    $trip_discount_value = $trip_price * $discount_value / 100;

                    if ($driver_balance < $trip_discount_value) {
                        return $this->sendResponse(true, "You don't have enough balance", "", 400);
                    }

                    $rider2->status = 'accepted';
                    $rider2->driver_id = Auth::user()->uuid;
                    $rider2->save();

                    //// send notifications
                    $recivers = User::where('uuid', $rider2->user_id)->first();
                    //// check user language
                    if ($recivers->language == 'en') {
                        $recivers1[] = ['uuid' => $recivers->uuid, 'token' => $recivers->device_token];
                        $body = 'Your request is accepted by ' . Auth::user()->name;
                        $data = ['title' => 'Request Accepted', 'body' => $body, 'sender' => Auth::user()->uuid, 'receiver' => $recivers1, 'notification_type' => 'Request_Accepted', 'request' => $request->request_id];
                        $this->sendNotification($data);
                    } elseif ($recivers->language == 'ar') {
                        $recivers1[] = ['uuid' => $recivers->uuid, 'token' => $recivers->device_token];
                        $body = ' تم قبول طلبك من قبل ' . Auth::user()->name;
                        $data = ['title' => 'الطلب مقبول', 'body' => $body, 'sender' => Auth::user()->uuid, 'receiver' => $recivers1, 'notification_type' => 'Request_Accepted', 'request' => $request->request_id];
                        $this->sendNotification($data);
                    }

                    return $this->sendResponse(true, 'The request is accepted successfully', "", 200);
                } else {
                    return $this->sendResponse(true, 'This request is not available anymore', "", 400);
                }
            } else {
                return $this->sendResponse(true, 'please try later', "", 400);
            }
        } catch (Exception $th) {
            return  $this->errorLog("DriverApiController@accept_request", $th->getMessage());
        }
    }

    /*
        Defintion:
            rate driver
        @Param:
            @param1_ driver_id (uuid)
            @param2_ rate (integer)

        @Response:
            message
    */
    public function rate_driver(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'driver_id' => 'required',
            'rate' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return $this->sendResponse(false, "", $validator->getMessageBag(), 400);
        }
        try {
            $user = User::where('uuid', $request->driver_id)->first();
            if (!$user) {
                return $this->sendResponse(true, 'The driver is not found', "", 400);
            }

            // add review
            if ($request->review != null) {
                Review::create([
                    'user_id' => Auth::user()->uuid,
                    'review' => $request->review
                ]);
            }

            if ($user->rate == null) {
                $user->rate = $request->rate;
                $user->save();
                return $this->sendResponse(true, 'The process is completed successfully', "", 200);
            } else {
                // $rate_driver=collect([$user->rate , $request->rate])->avg();
                $rate_driver = ($user->rate + $request->rate) / 2;
                $user->rate = $rate_driver;
                $user->save();

                return $this->sendResponse(true, 'The process is completed successfully', "", 200);
            }
        } catch (Exception $th) {
            return  $this->errorLog("DriverApiController@rate_driver", $th->getMessage());
        }
    }

    /*
        Defintion:
            Get Current Request
        @Params:
        @Response:
            data
    */
    public function driver_ride_request()
    {
        try {
            $rideRequest = RideRequest::where('driver_id', Auth::user()->uuid)->where('status', '!=', 'completed')->where('status', '!=', 'canceled')->first();
            if ($rideRequest == null) {
                return $this->sendResponse(false, 'No request found.', '', 400);
            }
            $estimate = Estimate::find($rideRequest->estimate_id);
            $driver = User::find($rideRequest->driver_id);
            $carType = CarType::find($estimate->car_type_id);
            $user = User::find($rideRequest->user_id);
            $response = [
                'ride_request' => [
                    'uuid' => $rideRequest->uuid,
                    'status' => $rideRequest->status,
                    'car_type_image' =>  $carType != null ? $carType->image : null,
                    'driver' => [
                        'country_code' => $driver != null ? $driver->country_code : null,
                        'phone' => $driver != null ? $driver->phone_number : null,
                        'image' => $driver != null ? $driver->image : null,
                        'name' => $driver != null ? $driver->name : null,
                    ],
                    'user' => [
                        'country_code' => $user->country_code,
                        'phone' => $user->phone_number,
                        'name' => $user->name,
                        'email' => $user->email,
                        'image' => $user->image
                    ],
                    'location' => [
                        'latitude' => $driver != null ? $driver->lat : null,
                        'longitude' => $driver != null ?  $driver->long : null,
                    ],
                    'vehicle' => [
                        'color' => $driver != null ? $driver->vehicleInformation->car_color : null,
                        'model' => $driver != null ? $driver->vehicleInformation->carModel->name : null,
                        'license_plate' => $driver != null ? $driver->vehicleInformation->license_plate : null
                    ]
                ],
                'estimate' => [
                    'uuid' => $estimate->uuid,
                    "duration_estimate" => $estimate->duration_estimate,
                    "distance_estimate" => $estimate->distance_estimate,
                    "estimated_value" => $estimate->estimated_value,
                    "pickup" => [
                        "name" => $estimate->pickup_name,
                        "latitude" => $estimate->pickup_lat,
                        "longitude" => $estimate->pickup_long,
                        "eta" => $estimate->pickup_eta
                    ],
                    "dropoff" => [
                        "name" => $estimate->dropoff_name,
                        "latitude" => $estimate->dropoff_lat,
                        "longitude" => $estimate->dropoff_long,
                        "eta" => $estimate->dropoff_eta
                    ]
                ]
            ];

            return $this->sendResponse(true, 'The process is completed successfully', $response, 200);
        } catch (Exception $th) {
            return $this->errorLog("DriverApiController@driver_ride_request", $th->getMessage());
        }
    }


    /*
        Defintion:
            get price for cards
        @Param:
        @Response:
            data
    */
    public function get_price(Request $request)
    {
        try {
            $validator = Validator::make($request->toArray(), [
                'code' => 'required',

            ]);
            if ($validator->fails()) {
                return $this->sendResponse(false, "", $validator->getMessageBag(), 400);
            }

            $card = [
                'code' => $request->code,

            ];

            // get authenticated user
            $user = auth("api")->user();

            if ($user != null) {
                $card = Card::where('code', $request->code)->first();
                if (!$card || !$card->code) {
                    return $this->sendResponse(false, "No code is found", "", 400);
                } else {
                    $data = [
                        'price' => $card->price,
                    ];
                    return $this->sendResponse(true, "The process is completed successfully", $data, 200);
                }
            } else {
                return $this->sendResponse(false, "Unauthorized, Please login and try again", "", 401);
            }
        } catch (Exception $th) {
            return  $this->errorLog("DriverApiController@get_price", $th->getMessage());
        }
    }

    /*
        Defintion:
          driver_credit
        @Param:code

        @Response:
            message
    */
    public function driver_credit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendResponse(false, "", $validator->getMessageBag(), 400);
        }
        try {

            $user = User::where('uuid', Auth::user()->uuid)->first();

            if ($user->driver_credit == null) {
                $card = Card::where('code', $request->code)->first();
                if (!$card || !$card->code) {
                    return $this->sendResponse(false, "No code is found", "", 400);
                } else {
                    $is_used = $card['is_used'];
                    if ($is_used == '1') {
                        return $this->sendResponse(false, "this card is used", "", 400);
                    } else {
                        $driver_credit = $card['price'];
                        $user->driver_credit = $driver_credit;
                        $user->save();
                        $driver_id = Auth::user()->uuid;
                        $card->driver_id = $driver_id;
                        $card->is_used = '1';
                        $card->save();
                    }

                    $data = [
                        'price' => $card->price,
                        'driver_credit' => number_format($user->driver_credit, 2),
                    ];

                    return $this->sendResponse(true, 'The process is completed successfully', $data, 200);
                }
            } else {
                $card = Card::where('code', $request->code)->first();
                if (!$card || !$card->code) {
                    return $this->sendResponse(false, "No code is found", "", 400);
                } else {

                    $is_used = $card['is_used'];
                    if ($is_used == '1') {
                        return $this->sendResponse(false, "this card is used", "", 400);
                    } else {
                        $driver_credit = $card['price'];
                        $driver_credit = $user->driver_credit + $driver_credit;
                        $user->driver_credit = $driver_credit;
                        $user->save();
                        $driver_id = Auth::user()->uuid;
                        $card->driver_id = $driver_id;
                        $card->is_used = '1';
                        $card->save();
                    }
                    $data = [
                        'price' => $card->price,
                        'driver_credit' => $user->driver_credit,
                    ];
                    return $this->sendResponse(true, 'The process is completed successfully', $data, 200);
                }
            }
        } catch (Exception $th) {
            return  $this->errorLog("DriverApiController@driver_credit", $th->getMessage());
        }
    }


    public function get_cards(Request $request)
    {
        try {


            $response = CardResource::collection(Card::where('driver_id', Auth::user()->uuid)->paginate(10))->response();

            $response = json_decode($response->content());

            $data = [
                'current_page' => $response->meta->current_page,
                'last_page' => $response->meta->last_page,
                'cards' => $response
            ];

            return $this->sendResponse(true, 'The process is completed successfully', $data, 200);
        } catch (Exception $th) {
            return $this->errorLog("DriverApiController@get_cards", $th->getMessage());
        }
    }


    /*
        Defintion:
            get_driver_credit
        @Params:
        @Response:
            data
    */
    public function driver_balance()
    {
        try {
            // get authenticated user
            $user = auth("api")->user();
            if ($user != null) {
                //////// send response
                $data = [
                    'driver balance' => number_format($user->driver_credit, 2),
                ];
                return $this->sendResponse(true, "The process is completed successfully", $data, 200);
            } else {
                return $this->sendResponse(false, "Unauthorized, Please login and try again", "", 401);
            }
        } catch (Exception $th) {
            return  $this->errorLog("DriverApiController@driver_balance", $th->getMessage());
        }
    }
}
