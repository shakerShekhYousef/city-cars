<?php

namespace App\Http\Controllers\Apis\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\EstimateResource;
use App\Http\Resources\RideRequestResource;
use App\Models\CarType;
use App\Models\DashboardData;
use App\Models\Estimate;
use App\Models\PromoCode;
use App\Models\RideRequest;
use App\Models\User;
use App\Models\VehicleInformation;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;
use Ramsey\Uuid\Nonstandard\Uuid;

class RequestController extends Controller
{

    public $maxDriverDisatnce = 1000000;

    /*
        Defintion:
            Get a Ride Estimate
            This API will return all available car types ordered by duration_estimate in the selected area and the ride estimate.
        @Params:
            @param1 _ start_lat
            @param2 _ start_long
            @param3 _ start_name
            @param4 _ end_lat
            @param5 _ end_long
            @param6 _ end_name
        @Response:
            data
    */
    public function get_ride_estimate(Request $request)
    {
        try {
            $validator = Validator::make($request->toArray(), [
                'start_lat' => 'required',
                'start_long' => 'required',
                'start_name' => 'required',
                'end_lat' => 'required',
                'end_long' => 'required',
                'end_name' => 'required'
            ]);
            if ($validator->fails())
                return $this->sendResponse(false, "", $validator->getMessageBag(), 400);

            $user = Auth('api')->user();
            if ($user != null) {

                $checkUserRequests = RideRequest::where('user_id', $user->uuid)->where('status', 'pending')
                    ->where('status', 'in_progress')
                    ->where('status', 'accepted')
                    ->count();
                if ($checkUserRequests > 0) {
                    return $this->sendResponse(false, "You already send a ride request", "", 400);
                }

                $driversList = DB::select(DB::raw("SELECT car_types.cost_per_km, car_types.initial_fee ,car_types.uuid, car_types.capacity, car_types.image ,car_types.display_name ,car_types.description, users.long, users.lat, car_models.car_type, 6371 * acos( cos( radians(" . $request->start_lat .
                    ") ) * cos( radians(users.lat) ) * cos( radians(users.long) - radians(" . $request->start_long . ") ) + sin( radians(" . $request->start_lat . ") ) * sin( radians(users.lat) )) as distance FROM ((users join vehicle_information on vehicle_information.driver_id = users.uuid) join car_models on vehicle_information.car_model = car_models.uuid) join car_types on car_models.car_type = car_types.uuid where (6371 * acos( cos( radians("
                    . $request->start_lat . ") ) * cos( radians(users.lat) ) * cos( radians(users.long) - radians(" . $request->start_long . ") ) + sin( radians(" . $request->start_lat .
                    ") ) * sin( radians(users.lat) ))) in ( select min(6371 * acos( cos( radians(" . $request->start_lat . ") ) * cos( radians(users.lat) ) * cos( radians(users.long) - radians("
                    . $request->start_long . ") ) + sin( radians(" . $request->start_lat . ") ) * sin( radians(users.lat) ))) as distance FROM ((users join vehicle_information on vehicle_information.driver_id = users.uuid) join car_models on vehicle_information.car_model = car_models.uuid) join car_types on car_models.car_type = car_types.uuid group by car_types.uuid)" .
                    " having distance <" . $this->maxDriverDisatnce));

                // $driversList = DB::select(DB::raw("SELECT car_types.cost_per_km ,car_types.uuid, car_types.capacity, car_types.image ,car_types.display_name ,car_types.description, users.long, users.lat, car_models.car_type, min(6371 * acos( cos( radians(" . $request->start_lat . ") ) * cos( radians(users.lat) ) * cos( radians(users.long) - radians(" . $request->start_long . ") ) + sin( radians(" . $request->start_lat . ") ) * sin( radians(users.lat) ) ) ) as distance FROM ((users join vehicle_information on vehicle_information.driver_id = users.uuid) join car_models on vehicle_information.car_model = car_models.uuid) join car_types on car_models.car_type = car_types.uuid group by car_models.car_type having distance <" . $this->maxDriverDisatnce));
                $data = [];

                if (count($driversList) == 0) {
                    return $this->sendResponse(false, "No drivers found", "", 404);
                }

                $distenationList = '';
                foreach ($driversList as $key => $driver) {
                    if ($key + 1 < count($driversList)) {
                        $distenationList .=  $driver->lat . "%2C" . $driver->long . "%7C";
                    } else {
                        $distenationList .=  $driver->lat . "%2C" . $driver->long;
                    }
                }

                $driverDistancesList = $this->googleCalculateMultiDistance($request->start_lat . "%2C" . $request->start_long, $distenationList);
                if ($driverDistancesList == null) {
                    return $this->sendResponse(false, "No drivers found", "", 404);
                }

                $distanceBetweenPickAndDropObj = $this->googleCalculateDistance($request->start_lat, $request->start_long, $request->end_lat, $request->end_long);
                $distanceBetweenPickAndDropObj =  $distanceBetweenPickAndDropObj['distance']['value'];
                // $distanceBetweenPickAndDropObj = $this->googleCalculateDistance($pickup_lat, $pickup_long, $dropoff_lat, $dropoff_long);
                foreach ($driversList as $key => $carType) {
                    $distanceFromDriverToUserObj = $driverDistancesList[$key];
                    // $distanceFromDriverToUserValue = $distanceFromDriverToUserObj['distance']['value'];
                    if (is_numeric($distanceBetweenPickAndDropObj)) {
                        $estimatedCost = $carType->cost_per_km * $distanceBetweenPickAndDropObj / 1000 + $carType->initial_fee;
                        $estimatedCost = number_format($estimatedCost, 2) . " " . config('app.currency');
                    } else {
                        $estimatedCost = '';
                    }
                    $data['car_types'][] = [
                        'id' => $carType->uuid,
                        'capacity' => $carType->capacity,
                        'image' => $carType->image,
                        'display_name' => $carType->display_name,
                        'description' => $carType->description,
                        'duration_estimate' => $distanceFromDriverToUserObj['duration']['value'] < 60 ? 'Nearby' :  $distanceFromDriverToUserObj['duration']['text'],
                        'duration_estimate_seconds' => $distanceFromDriverToUserObj['duration']['value'] < 60 ? 'Nearby' :  $distanceFromDriverToUserObj['duration']['value'],
                        'estimated_value' => $estimatedCost
                    ];
                }

                $distanceBetweenPickAndDropObj = ($this->googleCalculateDistance($request->start_lat, $request->start_long, $request->end_lat, $request->end_long));
                if ($distanceBetweenPickAndDropObj == null) {
                    return $this->sendResponse(false, "Start or end location not found", "", 404);
                }
                $data['estimate'] = [
                    'id' => 1,
                    'duration_estimate' => $distanceBetweenPickAndDropObj['duration']['text'],
                    'duration_estimate_seconds' => $distanceBetweenPickAndDropObj['duration']['value'],
                    'distance_estimate' => $distanceBetweenPickAndDropObj['distance']['text'],
                    'estimated_value' => '',
                    'pickup' => [
                        'name' => $request->start_name,
                        'latitude' => $request->start_lat,
                        'longitude' => $request->start_long,
                        'eta' => ''
                    ],
                    'dropoff' => [
                        'name' => $request->end_name,
                        'latitude' => $request->end_lat,
                        'longitude' => $request->end_long,
                        'eta' => $distanceBetweenPickAndDropObj['duration']['text']
                    ]
                ];

                return $this->sendResponse(true, "The process is completed successfully", $data, 200);
            } else {
                return $this->sendResponse(false, "Unauthorized, Please login and try again.", "", 401);
            }
        } catch (Exception $th) {
            $this->errorLog("RequestController@get_ride_estimate", $th->getMessage());
        }
    }
    /*
        Defintion:
            Request a Ride
        @Params:
            @param1 _ start_lat
            @param2 _ start_long
            @param3 _ start_name
            @param4 _ end_lat
            @param5 _ end_long
            @param6 _ end_name
            @param7 _ dropoff_eta
            @param8 _ duration_estimate
            @param9 _ distance_estimate
            @param10 _ car_type_id (uuid)
        @Response:
            data
    */

    public function request_a_ride(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'start_lat' => 'required',
                'start_long' => 'required',
                'start_name' => 'required',
                'end_lat' => 'required',
                'end_long' => 'required',
                'end_name' => 'required',
                'dropoff_eta' => 'required',
                'duration_estimate' => 'required',
                'distance_estimate' => 'required',
                'car_type_id' => 'required|exists:car_types,uuid',
            ]);
            if ($validator->fails()) {
                return $this->sendResponse(false, "Validation Errors", $validator->getMessageBag(), 400);
            }

            // promo code
            $valid_promo_code = false;
            if ($request->promo_code) {
                $promo = PromoCode::where('promo_code', $request->promo_code)->first();
                if (!$promo) {
                    return $this->sendResponse(false, "Promo code not found", null, 400);
                }
                /// check expiry date
                $current = strtotime(date("Y-m-d"));
                $end = strtotime($promo->expiry_date);
                $datediff =  $end - $current;
                $difference = floor($datediff / (60 * 60 * 24));
                if ($difference < 0) {
                    return $this->sendResponse(false, "Promo code isn't valid", null, 400);
                }
                // check usage limit
                if ($promo->users_number == $promo->usage_limit) {
                    return $this->sendResponse(false, "Prmo code exceed usage limitation", null, 400);
                }
                // valid an can be used
                $valid_promo_code = true;
                $userCount = $promo->users_number;
                $promo->users_number = $userCount + 1;
                $promo->save();
            }

            $car_type_id = $request->car_type_id;
            $dropoff_name = $request->end_name;
            $pickup_name = $request->start_name;
            $pickup_lat = $request->start_lat;
            $pickup_long = $request->start_long;
            $dropoff_lat = $request->end_lat;
            $dropoff_long = $request->end_long;
            $dropoff_eta = $request->dropoff_eta;

            $userId = 0;
            if (Auth::user())
                $userId = Auth::user()->uuid;

            // check if previous request found
            $previousRideRequest = RideRequest::where('user_id', $userId)->where('status', '!=', 'completed')->where('status', '!=', 'canceled')->count();
            if ($previousRideRequest > 0)
                return $this->sendResponse(false, 'You already make a request', '', 400);

            $carType = CarType::find($car_type_id);
            $car_type_initial_fee = $carType != null ? $carType->initial_fee : 0;

            $distanceBetweenPickAndDropObj = $this->googleCalculateDistance($pickup_lat, $pickup_long, $dropoff_lat, $dropoff_long);

            $costFromPickToDropForCarType = null;
            if ($distanceBetweenPickAndDropObj != null) {
                $costFromPickToDropForCarType = $carType->cost_per_km * $distanceBetweenPickAndDropObj['distance']['value'] / 1000 + $car_type_initial_fee;
                $costFromPickToDropForCarType = number_format($costFromPickToDropForCarType, 2);
            }

            $trip_cost = $costFromPickToDropForCarType;
            if ($valid_promo_code) {
                if ($promo->type == "percentage") {
                    $trip_cost -=  $trip_cost * $promo->value / 100;
                    $trip_cost = number_format($trip_cost, 2);
                } else if ($promo->type == "value") {
                    $trip_cost -=  $promo->value;
                    $trip_cost = number_format($trip_cost, 2);
                    if ($trip_cost < 0) {
                        return $this->sendResponse(false, "You can't apply this promo code here", null, 400);
                    }
                }
            }

            $estimate = [
                "duration_estimate" => $request->duration_estimate,
                "distance_estimate" => $request->distance_estimate,
                "estimated_value" => $trip_cost,
                "pickup" => [
                    "name" => $pickup_name,
                    "latitude" => $pickup_lat,
                    "longitude" => $pickup_long,
                    "eta" => null
                ],
                "dropoff" => [
                    "name" => $dropoff_name,
                    "latitude" => $dropoff_lat,
                    "longitude" => $dropoff_long,
                    "eta" => $dropoff_eta
                ]
            ];

            ///// insert into estimate table
            $estimateObj = Estimate::create([
                'uuid' => Uuid::uuid4(),
                'pickup_name' => $estimate['pickup']['name'],
                'pickup_lat' => $estimate['pickup']['latitude'],
                'pickup_long' => $estimate['pickup']['longitude'],
                'pickup_eta' => $estimate['pickup']['eta'],
                'dropoff_name' => $estimate['dropoff']['name'],
                'dropoff_lat' => $estimate['dropoff']['latitude'],
                'dropoff_long' => $estimate['dropoff']['longitude'],
                'dropoff_eta' => $estimate['dropoff']['eta'],
                'duration_estimate' => $estimate['duration_estimate'],
                'estimated_value' => $estimate['estimated_value'],
                'distance_estimate' => $estimate['distance_estimate'],
                'car_type_id' => $car_type_id,
                'user_id' => $userId
            ]);

            //// insert into rideRequest table
            $rideRequestObj = RideRequest::create([
                'uuid' => Uuid::uuid4(),
                'car_type_id' => $car_type_id,
                'estimate_id' => $estimateObj->uuid,
                'status' => 'pending',
                'user_id' => $userId
            ]);

            $response = [
                'estimate' => [
                    "duration_estimate" => $request->duration_estimate,
                    "distance_estimate" => $request->distance_estimate,
                    "estimated_value" => $trip_cost,
                    "pickup" => [
                        "name" => $pickup_name,
                        "latitude" => $pickup_lat,
                        "longitude" => $pickup_long,
                        "eta" => null
                    ],
                    "dropoff" => [
                        "name" => $dropoff_name,
                        "latitude" => $dropoff_lat,
                        "longitude" => $dropoff_long,
                        "eta" => $dropoff_eta
                    ]
                ],
                'ride_request' => [
                    'uuid' => $rideRequestObj->uuid,
                    'status' => 'pending',
                    'car_type_image' => $carType->image,
                    'driver' => null,
                    'location' => null,
                    'vehicle' => null
                ]
            ];

            //// send notifications
            $recivers = $this->getNearByDrivers($this->maxDriverDisatnce, Auth::user()->lat, Auth::user()->long, $car_type_id);
            $data = ['title' => 'New Request', 'body' => 'A new request is added', 'sender' => Auth::user()->uuid, 'receiver' => $recivers, 'notification_type' => 'New_Request', 'request' => $rideRequestObj->uuid];
            $this->sendNotification($data);

            return $this->sendResponse(true, 'The process is completed successfully', $response, 201);
        } catch (Exception $th) {
            $this->errorLog("RequestController@request_a_ride", $th->getMessage());
        }
    }

    /*
        get promo data
    */
    public function promo_code($code_id)
    {
        $promo = PromoCode::where('promo_code', $code_id)->first();
        if (!$promo) {
            return $this->sendResponse(false, "Promo code not found", null, 400);
        }
        /// check expiry date
        $current = strtotime(date("Y-m-d"));
        $end = strtotime($promo->expiry_date);
        $datediff =  $end - $current;
        $difference = floor($datediff / (60 * 60 * 24));
        if ($difference < 0) {
            return $this->sendResponse(false, "Promo code isn't valid", null, 400);
        }
        // check usage limit
        if ($promo->users_number == $promo->usage_limit) {
            return $this->sendResponse(false, "Prmo code exceed usage limitation", null, 400);
        }
        return $this->sendResponse(true, 'The process is completed successfully', $promo, 200);
    }


    /*
        Defintion:
            Get Ride Request Information
        @Params:
            @param1 _ ride_request_id

        @Response:
            data
    */
    public function ride_request($rideRequestId)
    {
        try {
            $rideRequest = RideRequest::find($rideRequestId);
            if ($rideRequest == null) {
                return $this->sendResponse(false, 'Ride request not found', '', 400);
            }

            // get estimate data
            $estimate = Estimate::find($rideRequest->estimate_id);
            // get driver data
            $driver = User::find($rideRequest->driver_id);
            // get car type data
            $carType = CarType::find($estimate->car_type_id);
            // response
            $response = [
                'ride_request' => [
                    'uuid' => $rideRequest->uuid,
                    'status' => $rideRequest->status,
                    'front_image' => $driver != null ? $driver->vehicleInformation->front_image : null,
                     // 'car_type_image' => $carType->image,
                    'driver' => [
                        'driver_id' => $driver != null ? $driver->uuid : null,
                        'country_code' => $driver != null ? $driver->country_code : null,
                        'phone' => $driver != null ? $driver->phone_number : null,
                        'image' => $driver != null ? $driver->image : null,
                        'name' => $driver != null ? $driver->name : null,
                        'rate' => $driver != null ? $driver->rate : null
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
            return $this->errorLog("RequestController@ride_request", $th->getMessage());
        }
    }


    /*
        Defintion:
            Get Current Request
            Check if the user has an active request
        @Params:
        @Response:
            data
    */
    public function user_ride_request()
    {
        try {
            $rideRequest = RideRequest::where('user_id', Auth::user()->uuid)->where('status', '!=', 'completed')->where('status', '!=', 'canceled')->first();
            if ($rideRequest == null) {
                return $this->sendResponse(false, 'No request found.', '', 400);
            }

            // get estimate data
            $estimate = Estimate::find($rideRequest->estimate_id);
            // get driver data
            $driver = User::find($rideRequest->driver_id);
            // get car type data
            $carType = CarType::find($estimate->car_type_id);
            // response
            $response = [
                'ride_request' => [
                    'uuid' => $rideRequest->uuid,
                    'status' => $rideRequest->status,
                    'front_image' => $driver != null ? $driver->vehicleInformation->front_image : null,

                    // 'car_type_image' => $carType->image,
                    'driver' => [
                        'driver_id' => $driver != null ? $driver->uuid : null,
                        'country_code' => $driver != null ? $driver->country_code : null,
                        'phone' => $driver != null ? $driver->phone_number : null,
                        'image' => $driver != null ? $driver->image : null,
                        'name' => $driver != null ? $driver->name : null,
                        'rate' => $driver != null ? $driver->rate : null,
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
            return $this->errorLog("RequestController@user_ride_request", $th->getMessage());
        }
    }


    /*
        Defintion:
            Get Requests History
            Get requests history filtered by a specific day and paginated (10 requests per page).
            This API will return a list of request details objects {request, estimate}.
        @Params:
            @param1 _ data
            @param2 _page
        @Response:
            data
    */
    public function requests_history(Request $request)
    {
        try {
            $date  = null;
            $response = null;
            /// validate passed date
            if ($request->query('date') != null) {
                if (!$this->validateDate($request->query('date'))) {
                    return $this->sendResponse(false, 'Date note valid!', '', 400);
                }
                $date = Carbon::parse($request->query('date'));
            }

            if ($date != null) {
                if (Auth::user()->isUser()) {
                    $response = RideRequestResource::collection(RideRequest::where('user_id', Auth::user()->uuid)->whereDate('created_at', $date)->orderBy('created_at', 'desc')->paginate(10))->response();
                } else if (Auth::user()->isDriver()) {
                    $response = RideRequestResource::collection(RideRequest::where('driver_id', Auth::user()->uuid)->whereDate('created_at', $date)->orderBy('created_at', 'desc')->paginate(10))->response();
                }
            } else {
                if (Auth::user()->isUser()) {
                    $response =  RideRequestResource::collection(RideRequest::where('user_id', Auth::user()->uuid)->orderBy('created_at', 'desc')->paginate(10))->response();
                } else  if (Auth::user()->isDriver()) {
                    $response =  RideRequestResource::collection(RideRequest::where('driver_id', Auth::user()->uuid)->orderBy('created_at', 'desc')->paginate(10))->response();
                }
            }
            $response = json_decode($response->content());
            $final = [
                'current_page' => $response->meta->current_page,
                'last_page' => $response->meta->last_page,
                'requests_history' => $response->data
            ];
            // $response = ['requests_history' => $response];
            // return $final;
            return $this->sendResponse(true, 'The process is completed successfully', $final, 200);
        } catch (Exception $th) {
            return $this->errorLog("RequestController@requests_history", $th->getMessage());
        }
    }

    /*
        Defintion:
            Change request status from current status to one of three type, driver_arrived, rider_picked_up, completed.
        @Params:
            @param1 _  (uuid) request_id
            @param2 _  (string) status
        @Response:
            message
    */
    public function change_status_request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'request_id' => 'required',
            'status' => 'required|in:completed,rider_picked_up,driver_arrived',
        ]);
        if ($validator->fails()) {
            return $this->sendResponse(false, "", $validator->getMessageBag(), 400);
        }
        try {
            $UserOrDriver = Auth::user()->uuid;
            $rider = RideRequest::where('uuid', $request->request_id)->first();
            if (!$rider) {
                return $this->sendResponse(true, 'The request is not found', "", 400);
            }
            if ($rider->status == "completed") {
                return $this->sendResponse(true, 'The request is completed', "", 400);
            }
            if ($rider->status == "pending") {
                return $this->sendResponse(true, 'The request is pending', "", 400);
            }

            // if driver
            /// accepted, driver_arrived, rider_picked_up, completed
            if ($rider->driver_id == $UserOrDriver) {
                if ($rider->status == "accepted") {
                    if ($request->status == "accepted" || $request->status == "rider_picked_up" || $request->status == "completed") {
                        return $this->sendResponse(true, 'The status is not true', '', 400);
                    } else {
                        $rider->status = $request->status;
                        $rider->save();

                        // send notifications

                        $recivers = User::where('uuid', $rider->user_id)->first();
                        //// check user language                
                        if ($recivers->language == 'en') {
                            $recivers1[] = ['uuid' => $recivers->uuid, 'token' => $recivers->device_token];
                            $body = 'Your driver ' . Auth::user()->name . ' is arrived';
                            $data = ['title' => 'Driver Arrived', 'body' => $body, 'sender' => Auth::user()->uuid, 'receiver' => $recivers1, 'notification_type' => 'Driver_Arrived', 'request' => $request->request_id];
                            $this->sendNotification($data);
                        } elseif ($recivers->language == 'ar') {
                            $recivers1[] = ['uuid' => $recivers->uuid, 'token' => $recivers->device_token];
                            $body = ' سائقك ' . Auth::user()->name . ' قد وصل ';
                            $data = ['title' => 'وصل السائق', 'body' => $body, 'sender' => Auth::user()->uuid, 'receiver' => $recivers1, 'notification_type' => 'Driver_Arrived', 'request' => $request->request_id];
                            $this->sendNotification($data);
                        }

                        return $this->sendResponse(true, 'The process is completed successfully', '', 200);
                    }
                } else if ($rider->status == "driver_arrived") {
                    if ($request->status == "accepted" || $request->status == "driver_arrived" || $request->status == "completed") {
                        return $this->sendResponse(true, 'The status is not true', '', 400);
                    } else {
                        $rider->status = $request->status;
                        $rider->save();

                        // send notifications
                        $recivers = User::where('uuid', $rider->user_id)->first();
                        //// check user language                
                        if ($recivers->language == 'en') {
                            $recivers1[] = ['uuid' => $recivers->uuid, 'token' => $recivers->device_token];
                            $data = ['title' => 'Rider Picked Up', 'body' => 'You are on the way, enjoy', 'sender' => Auth::user()->uuid, 'receiver' => $recivers1, 'notification_type' => 'Rider_Picked_Up', 'request' => $request->request_id];
                            $this->sendNotification($data);
                        } elseif ($recivers->language == 'ar') {
                            $recivers1[] = ['uuid' => $recivers->uuid, 'token' => $recivers->device_token];
                            $data = ['title' => 'صعود الراكب', 'body' => 'أنت على الطريق ، استمتع', 'sender' => Auth::user()->uuid, 'receiver' => $recivers1, 'notification_type' => 'Rider_Picked_Up', 'request' => $request->request_id];
                            $this->sendNotification($data);
                        }

                        return $this->sendResponse(true, 'The process is completed successfully', '', 200);
                    }
                } elseif ($rider->status == "rider_picked_up") {
                    if ($request->status == "accepted" || $request->status == "driver_arrived" || $request->status == "rider_picked_up") {
                        return $this->sendResponse(true, 'The status is not true', '', 400);
                    } else {
                        $rider->status = $request->status;
                        $rider->save();

                        /////////////////////////// discount driver balance ///////////////////////////
                        // get trip cost
                        $estimate = Estimate::where('uuid', $rider->estimate_id)->first();
                        $trip_price =  $estimate->estimated_value;
                        $trip_price = $trip_price != null ? floatval($trip_price) : 0;
                        // get driver balance
                        $driver_balance = Auth::user()->driver_credit;
                        // get discount percentage
                        $discount_value = DashboardData::first()->percentage;
                        $discount_value = $discount_value != null ? floatval($discount_value) : 0;

                        // get trip discount value
                        $trip_discount_value = $trip_price * $discount_value / 100;
                        // update balance
                        $new_balance =  floatval($driver_balance) - floatval($trip_discount_value);
                        User::where('uuid', Auth::user()->uuid)->update([
                            'driver_credit' => $new_balance
                        ]);


                        // send notifications
                        $recivers = User::where('uuid', $rider->user_id)->first();
                        //// check user language                
                        if ($recivers->language == 'en') {
                            $recivers1[] = ['uuid' => $recivers->uuid, 'token' => $recivers->device_token];
                            $data = ['title' => 'Request Completed', 'body' => 'Your request is completed, thank you for using City Cars app', 'sender' => Auth::user()->uuid, 'receiver' => $recivers1, 'notification_type' => 'Request_Completed', 'request' => $request->request_id];
                            $this->sendNotification($data);
                        } elseif ($recivers->language == 'ar') {
                            $recivers1[] = ['uuid' => $recivers->uuid, 'token' => $recivers->device_token];
                            $data = ['title' => 'الطلب مكتمل', 'body' => ' City Cars تم إكمال طلبك ، شكرًا لك على استخدام تطبيق', 'sender' => Auth::user()->uuid, 'receiver' => $recivers1, 'notification_type' => 'Request_Completed', 'request' => $request->request_id];
                            $this->sendNotification($data);
                        }

                        return $this->sendResponse(true, 'The process is completed successfully', '', 200);
                    }
                } else {
                    return $this->sendResponse(true, 'The request is not available', '', 400);
                }
            } else {
                return $this->sendResponse(true, 'The request is not available', '', 400);
            }
        } catch (Exception $th) {
            return  $this->errorLog("RequestController@change_status_request", $th->getMessage());
        }
    }

    /*
        Defintion:
            cancel_request
        @Param:
            @param1_ request_id (uuid)
        @Response:
            message
    */
    public function cancel_request(Request $request)
    {
        try {
            $requests = RideRequest::where('uuid', $request->request_id)->where('user_id', Auth::user()->uuid)->first();
            if (!$requests) {
                return $this->sendResponse(true, 'The request is not found', "", 400);
            }
            if ($requests->status != 'pending') {
                return $this->sendResponse(true, "you can't cancel request", "", 400);
            } else {
                $requests->status = "canceled";
                $requests->save();
                return $this->sendResponse(true, 'The process is completed successfully', "", 200);
            }
        } catch (Exception $th) {
            return  $this->errorLog("RequestController@cancel_request", $th->getMessage());
        }
    }
}
