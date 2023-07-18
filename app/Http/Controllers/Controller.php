<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function errorLog($src, $body)
    {
        ErrorLog::create([
            'src' => $src,
            'body' => $body,
        ]);
        return response()->json(['success' => false, 'messsage' => 'Something went wrong. Please try again later.'], 500);
    }

    public function sendResponse($success, $message = null, $data = null, $code = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    function calculateDistanceBetweenTwoAddresses($lat1, $lng1, $lat2, $lng2)
    {
        $lat1 = deg2rad($lat1);
        $lng1 = deg2rad($lng1);

        $lat2 = deg2rad($lat2);
        $lng2 = deg2rad($lng2);

        $delta_lat = $lat2 - $lat1;
        $delta_lng = $lng2 - $lng1;

        $hav_lat = (sin($delta_lat / 2)) ** 2;
        $hav_lng = (sin($delta_lng / 2)) ** 2;

        $distance = 2 * asin(sqrt($hav_lat + cos($lat1) * cos($lat2) * $hav_lng));

        $distance = 6371 * $distance;
        // If you want calculate the distance in miles instead of kilometers, replace 6371 with 3959.

        return $distance;
    }

    public function googleCalculateMultiDistance($origin, $destination)
    {
        try {
            $apiUrl = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $origin . "&destinations=" . $destination . "&key=" . config('auth.google_api_key');
            $driverClient = Http::get($apiUrl);
            if ($driverClient->status() == 200) {
                if ($driverClient->json()['rows'] != null) {
                    if ($driverClient->json()['rows'][0]['elements'][0]['status'] == "ZERO_RESULTS")
                        return null;
                    else
                        return $driverClient->json()['rows'][0]['elements'];
                } else {
                    return null;
                }
            } else {
                return $this->sendResponse(false, "Unable to connect to google api", "", 400);
            }
            //code...
        } catch (\Throwable $th) {
            $this->errorLog("Controller@googleCalculateMultiDistance", $th->getMessage());
        }
    }

    public function googleCalculateDistance($start_lat, $start_long, $dest_lat, $dest_long)
    {
        try {
            $origin = $start_lat . "%2C" . $start_long;
            $destination = $dest_lat . "%2C" . $dest_long;
            $apiUrl = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $origin . "&destinations=" . $destination . "&key=" . config('auth.google_api_key');
            $driverClient = Http::get($apiUrl);
            if ($driverClient->status() == 200) {
                if ($driverClient->json()['rows'] != null) {
                    if ($driverClient->json()['rows'][0]['elements'][0]['status'] == "ZERO_RESULTS")
                        return null;
                    else
                        return $driverClient->json()['rows'][0]['elements'][0];
                } else {
                    return null;
                }
            } else {
                return $this->sendResponse(false, "Unable to connect to google api", "", 400);
            }
        } catch (\Throwable $th) {
            $this->errorLog("Controller@googleCalculateDistance", $th->getMessage());
        }
    }

    public function googleCalculateDistanceValue($start_lat, $start_long, $dest_lat, $dest_long)
    {
        $origin = $start_lat . "%2C" . $start_long;
        $destination = $dest_lat . "%2C" . $dest_long;
        $apiUrl = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $origin . "&destinations=" . $destination . "&key=" . config('auth.google_api_key');
        $driverClient = Http::get($apiUrl);
        return $driverClient->json()['rows'][0]['elements'][0]['distance']['value'];
    }

    public function googleCalculateDistanceText($start_lat, $start_long, $dest_lat, $dest_long)
    {
        $origin = $start_lat . "%2C" . $start_long;
        $destination = $dest_lat . "%2C" . $dest_long;
        $apiUrl = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $origin . "&destinations=" . $destination . "&key=" . config('auth.google_api_key');
        $driverClient = Http::get($apiUrl);
        return $driverClient->json()['rows'][0]['elements'][0]['distance']['text'];
    }

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /*
        $data=['title' => '', 'body' => '', 'sender' => '', 'receiver' => '', 'notification_type' => '', 'request' => '']
    */
    public function sendNotification($data)
    {
        ////////////////////////////////////////////////////////

        try {
            if (isset($data['type'])) {
                if ($data['type'] == 1) {
                    /////// users_tokens
                    $FirebaseKey = config('services.firebase.firebase_key_user');
                    $url = 'https://fcm.googleapis.com/fcm/send';

                    $headers = array(
                        'Authorization: key=' . $FirebaseKey,
                        'Content-Type: application/json'
                    );
                    ////////////////////////////////////////////////////////
                    $counter = 0;
                    $tokenList = [];
                    $tempo = [];
                    $notification_body = [];
                    foreach ($data['users_tokens'] as $key => $to) {
                        if ($to->device_token != "") {
                            array_push($tempo, $to->device_token);
                            $tokenList[$counter] = $tempo;
                            if (count($tempo) % 1000 == 0) {
                                $counter += 1;
                                $tempo = [];
                            }

                            $notification_body[] = [
                                'uuid' => Uuid::uuid4(),
                                'title' => $data['title'],
                                'body' => $data['body'],
                                'sender' => $data['sender'],
                                'receiver' => $to->uuid,
                                'notification_type' => $data['notification_type'],
                                'created_at' => now()->toDateTimeString(),
                                'updated_at' => now()->toDateTimeString()
                            ];
                        }
                    }

                    for ($i = 0; $i < count($tokenList); $i++) {
                        $payload = '{
                                        "registration_ids" :["' . implode('","', $tokenList[$i]) . '"] ,
                                        "notification": {
                                            "title": "' . $data['title'] . '",
                                            "body": "' . $data['body'] . '",
                                        },
                                        "priority": "high",
                                        "data": {
                                            "click_action": "FLUTTER_NOTIFICATION_CLICK",
                                            "type": "' . $data['notification_type'] . '",
                                            "status": "done"
                                        }
                                    }';

                        // Open connection
                        $ch = curl_init();
                        // Set the url, number of POST vars, POST data
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        // Execute post
                        $result = curl_exec($ch);

                        // if ($result === FALSE) {
                        //     die('Curl failed: ' . curl_error($ch));
                        // }
                        curl_close($ch);
                    }

                    if (count($notification_body) > 0) {
                        Notification::insert($notification_body);
                    }
                } else if ($data['type'] == 2) {
                    /////// drivers_tokens
                    $FirebaseKey = config('services.firebase.firebase_key_driver');
                    $url = 'https://fcm.googleapis.com/fcm/send';

                    $headers = array(
                        'Authorization: key=' . $FirebaseKey,
                        'Content-Type: application/json'
                    );
                    ////////////////////////////////////////////////////////
                    $counter = 0;
                    $tokenList = [];
                    $tempo = [];
                    $notification_body = [];
                    foreach ($data['drivers_tokens'] as $key => $to) {
                        if ($to->device_token != "") {
                            array_push($tempo, $to->device_token);
                            $tokenList[$counter] = $tempo;
                            if (count($tempo) % 1000 == 0) {
                                $counter += 1;
                                $tempo = [];
                            }

                            $notification_body[] = [
                                'uuid' => Uuid::uuid4(),
                                'title' => $data['title'],
                                'body' => $data['body'],
                                'sender' => $data['sender'],
                                'receiver' => $to->uuid,
                                'notification_type' => $data['notification_type'],
                                'created_at' => now()->toDateTimeString(),
                                'updated_at' => now()->toDateTimeString()
                            ];
                        }
                    }

                    for ($i = 0; $i < count($tokenList); $i++) {
                        $payload = '{
                                        "registration_ids" :["' . implode('","', $tokenList[$i]) . '"] ,
                                        "notification": {
                                            "title": "' . $data['title'] . '",
                                            "body": "' . $data['body'] . '",
                                        },
                                        "priority": "high",
                                        "data": {
                                            "click_action": "FLUTTER_NOTIFICATION_CLICK",
                                            "type": "' . $data['notification_type'] . '",
                                            "status": "done"
                                        }
                                    }';

                        // Open connection
                        $ch = curl_init();
                        // Set the url, number of POST vars, POST data
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        // Execute post
                        $result = curl_exec($ch);
                        // dd($result);
                        // if ($result === FALSE) {
                        //     die('Curl failed: ' . curl_error($ch));
                        // }
                        curl_close($ch);
                    }
                    if (count($notification_body) > 0) {
                        Notification::insert($notification_body);
                    }
                } else if ($data['type'] == 3 || $data['type'] == 4) {
                    /////// custome
                    $FirebaseKey = config('services.firebase.firebase_key_user');
                    $url = 'https://fcm.googleapis.com/fcm/send';

                    $headers = array(
                        'Authorization: key=' . $FirebaseKey,
                        'Content-Type: application/json'
                    );
                    ////////////////////////////////////////////////////////
                    $counter = 0;
                    $tokenList = [];
                    $tempo = [];
                    $notification_body = [];

                    foreach ($data['users_tokens'] as $key => $to) {
                        if ($to->device_token != "") {
                            array_push($tempo, $to->device_token);
                            $tokenList[$counter] = $tempo;
                            if (count($tempo) % 1000 == 0) {
                                $counter += 1;
                                $tempo = [];
                            }

                            $notification_body[] = [
                                'uuid' => Uuid::uuid4(),
                                'title' => $data['title'],
                                'body' => $data['body'],
                                'sender' => $data['sender'],
                                'receiver' => $to->uuid,
                                'notification_type' => $data['notification_type'],
                                'created_at' => now()->toDateTimeString(),
                                'updated_at' => now()->toDateTimeString()
                            ];
                        }
                    }

                    for ($i = 0; $i < count($tokenList); $i++) {
                        $payload = '{
                                        "registration_ids" :["' . implode('","', $tokenList[$i]) . '"] ,
                                        "notification": {
                                            "title": "' . $data['title'] . '",
                                            "body": "' . $data['body'] . '",
                                        },
                                        "priority": "high",
                                        "data": {
                                            "click_action": "FLUTTER_NOTIFICATION_CLICK",
                                            "type": "' . $data['notification_type'] . '",
                                            "status": "done"
                                        }
                                    }';

                        // Open connection
                        $ch = curl_init();
                        // Set the url, number of POST vars, POST data
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        // Execute post
                        $result = curl_exec($ch);
                        // dd($result);
                        // if ($result === FALSE) {
                        //     die('Curl failed: ' . curl_error($ch));
                        // }
                        curl_close($ch);
                    }


                    if (count($notification_body) > 0) {
                        Notification::insert($notification_body);
                    }

                    /////////////////////////////////////////////////////////////////////////////////////////////////////
                    /////// drivers_tokens
                    $FirebaseKey = config('services.firebase.firebase_key_driver');
                    $url = 'https://fcm.googleapis.com/fcm/send';

                    $headers = array(
                        'Authorization: key=' . $FirebaseKey,
                        'Content-Type: application/json'
                    );
                    ////////////////////////////////////////////////////////
                    $counter = 0;
                    $tokenList = [];
                    $tempo = [];
                    $notification_body = [];
                    foreach ($data['drivers_tokens'] as $key => $to) {
                        if ($to->device_token != "") {
                            array_push($tempo, $to->device_token);
                            $tokenList[$counter] = $tempo;
                            if (count($tempo) % 1000 == 0) {
                                $counter += 1;
                                $tempo = [];
                            }

                            $notification_body[] = [
                                'uuid' => Uuid::uuid4(),
                                'title' => $data['title'],
                                'body' => $data['body'],
                                'sender' => $data['sender'],
                                'receiver' => $to->uuid,
                                'notification_type' => $data['notification_type'],
                                'created_at' => now()->toDateTimeString(),
                                'updated_at' => now()->toDateTimeString()
                            ];
                        }
                    }

                    for ($i = 0; $i < count($tokenList); $i++) {
                        $payload = '{
                                        "registration_ids" :["' . implode('","', $tokenList[$i]) . '"] ,
                                        "notification": {
                                            "title": "' . $data['title'] . '",
                                            "body": "' . $data['body'] . '",
                                        },
                                        "priority": "high",
                                        "data": {
                                            "click_action": "FLUTTER_NOTIFICATION_CLICK",
                                            "type": "' . $data['notification_type'] . '",
                                            "status": "done"
                                        }
                                    }';


                        // Open connection
                        $ch = curl_init();
                        // Set the url, number of POST vars, POST data
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        // Execute post
                        $result = curl_exec($ch);
                        // dd($result);
                        // if ($result === FALSE) {
                        //     die('Curl failed: ' . curl_error($ch));
                        // }
                        curl_close($ch);
                    }

                    if (count($notification_body) > 0) {
                        Notification::insert($notification_body);
                    }
                }
            } else {
                // driver app
                $url = 'https://fcm.googleapis.com/fcm/send';

                if ($data['notification_type'] == "New_Request") {
                    $FirebaseKey = config('services.firebase.firebase_key_driver');

                    $headers = array(
                        'Authorization: key=' . $FirebaseKey,
                        'Content-Type: application/json'
                    );
                    ////////////////////////////////////////////////////////

                    $notification_body = [];
                    foreach ($data['receiver'] as $key => $to) {
                        if ($to['language'] == "en") {
                            $data['title'] = "New Request";
                            $data['body'] = "A new request is added";
                        } else if ($to['language'] == "ar") {
                            $data['title'] = "طلب جديد";
                            $data['body'] = "تم إضافة طلب جديد";
                        }

                        $payload = '{
                                        "notification": {
                                            "title": "' . $data['title'] . '",
                                            "body": "' . $data['body'] . '",
                                        },
                                        "priority": "high",
                                        "data": {
                                            "click_action": "FLUTTER_NOTIFICATION_CLICK",
                                            "type": "' . $data['notification_type'] . '",
                                            "status": "done"
                                        },
                                        "to":"' . $to['token'] . '"
                                    }';

                        // Open connection
                        $ch = curl_init();
                        // Set the url, number of POST vars, POST data
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        // Execute post
                        $result = curl_exec($ch);

                        if ($result === FALSE) {
                            die('Curl failed: ' . curl_error($ch));
                        }
                        curl_close($ch);

                        $notification_body[] = [
                            'uuid' => Uuid::uuid4(),
                            'title' => $data['title'],
                            'body' => $data['body'],
                            'sender' => $data['sender'],
                            'receiver' => $to['uuid'],
                            'notification_type' => $data['notification_type'],
                            'request' => $data['request'],
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }

                    if (count($notification_body) > 0) {
                        Notification::insert($notification_body);
                    }
                }
                // user app
                else if ($data['notification_type'] == "Driver_Arrived" || $data['notification_type'] == "Request_Accepted" || $data['notification_type'] == "Request_Completed" || $data['notification_type'] == "Rider_Picked_Up") {
                    $FirebaseKey = config('services.firebase.firebase_key_user');

                    $headers = array(
                        'Authorization: key=' . $FirebaseKey,
                        'Content-Type: application/json'
                    );
                    ////////////////////////////////////////////////////////
                    $counter = 0;
                    $tokenList = [];
                    $tempo = [];
                    $notification_body = [];
                    foreach ($data['receiver'] as $key => $to) {
                        array_push($tempo, $to['token']);
                        $tokenList[$counter] = $tempo;
                        if (count($tempo) % 1000 == 0) {
                            $counter += 1;
                            $tempo = [];
                        }

                        $notification_body[] = [
                            'uuid' => Uuid::uuid4(),
                            'title' => $data['title'],
                            'body' => $data['body'],
                            'sender' => $data['sender'],
                            'receiver' => $to['uuid'],
                            'notification_type' => $data['notification_type'],
                            'request' => $data['request'],
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }

                    for ($i = 0; $i < count($tokenList); $i++) {
                        $payload = '{
                                        "registration_ids" :["' . implode('","', $tokenList[$i]) . '"] ,
                                        "notification": {
                                            "title": "' . $data['title'] . '",
                                            "body": "' . $data['body'] . '",
                                        },
                                        "priority": "high",
                                        "data": {
                                            "click_action": "FLUTTER_NOTIFICATION_CLICK",
                                            "type": "' . $data['notification_type'] . '",
                                            "status": "done"
                                        }
                                    }';

                        // Open connection
                        $ch = curl_init();
                        // Set the url, number of POST vars, POST data
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        // Execute post
                        $result = curl_exec($ch);
                        // dd($result);
                        // if ($result === FALSE) {
                        //     die('Curl failed: ' . curl_error($ch));
                        // }
                        curl_close($ch);
                    }

                    if (count($notification_body) > 0) {
                        Notification::insert($notification_body);
                    }
                    ////////////////////////////////////////////////////////
                }
            }
            return true;
        } catch (\Exception $th) {
            return  $this->errorLog("Controller@send_notification", $th->getMessage());
        }
    }

    public function getNearByDrivers($distance = 1, $lat, $long, $typeId)
    {
        $driversList = DB::select(DB::raw("SELECT users.uuid, users.device_token, language FROM users
        where 6371 * acos( cos(radians('$lat')) * cos(radians(users.lat)) * cos(radians(users.long) - radians('$long')) + sin(radians('$lat')) * sin(radians(users.lat)))
        in (
            select 6371 * acos( cos(radians('$lat')) * cos(radians(users.lat)) * cos(radians(users.long) - radians('$long')) + sin(radians('$lat')) * sin(radians(users.lat))) as distance
        FROM ((users join vehicle_information on vehicle_information.driver_id = users.uuid) join car_models on vehicle_information.car_model = car_models.uuid) join car_types on car_models.car_type = car_types.uuid
        where car_types.uuid = '$typeId' and users.role='Driver'
        having distance < $distance
            )"));
        $driverArray = [];
        foreach ($driversList as $key => $driver) {
            $driverArray[] = ['uuid' => $driver->uuid, 'token' => $driver->device_token, 'language' => $driver->language];
        }
        return $driverArray;
    }

    public function sendChangeBalanceNotificationToDriver($driver_token)
    {
        $FirebaseKey = config('services.firebase.firebase_key_driver');
        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = array(
            'Authorization: key=' . $FirebaseKey,
            'Content-Type: application/json'
        );
        ////////////////////////////////////////////////////////

        $payload = '{
            "registration_ids" :["' . $driver_token . '"] ,
            "notification": {
                "title": "Balance Changed",
                "body": "",
            },
            "priority": "high",
            "data": {
                "click_action": "FLUTTER_NOTIFICATION_CLICK",
                "type": "Balance Changed",
                "status": "done"
            }
        }';

        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Execute post
        $result = curl_exec($ch);

        // if ($result === FALSE) {
        //     die('Curl failed: ' . curl_error($ch));
        // }
        curl_close($ch);

        $temp = User::where('device_token', $driver_token)->first();
        if ($temp) {
            $notification_body = [
                'uuid' => Uuid::uuid4(),
                'title' => "Balance Changed",
                'body' => "",
                'sender' => Auth::user()->uuid,
                'receiver' => $temp != null ? $temp->uuid : null,
                'notification_type' => "Balance Changed",
                'request' => "",
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ];

            Notification::create($notification_body);
        }
    }
}
