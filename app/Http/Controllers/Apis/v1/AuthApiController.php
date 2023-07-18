<?php


namespace App\Http\Controllers\Apis\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodResource;
use App\Http\Resources\UserResource;
use App\Models\home_data;
use App\Models\PaymentMethod;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Ramsey\Uuid\Uuid as UuidUuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Else_;

class AuthApiController extends Controller
{
    /*
        Defintion:
            register a new user
        @Params:
            @param1 _  name
            @param2 _  country_code
            @param3 _  phone_number
            @param3 _  email
            @param3 _  password


        @Response:
            data
    */
    public function sign_up(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'name' => 'required',
            'country_code' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email',
            'password' => 'required'
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
                'role' => 'User'
            ]);
            $tokenResult =  $user->createToken('authToken');
            $response = [
                'success' => "true",
                'message' => "User created successfully",
                "data" => array(
                    'token' =>  $tokenResult->accessToken,
                    'user' => UserResource::make($user),
                    'home data' => ($home_data) ? $home_data : null
                )
            ];

            return response($response, 201);
        } catch (Exception $th) {
            return  $this->errorLog("AuthApiController@sign_up", $th->getMessage());
        }
    }
    /*
        Defintion:
            user Login request using email and password.
        @Params:
            @param1 _  email
            @param2 _  password
        @Response:
            data
    */

    public function login(Request $request)
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
                $token = $user->createToken('LaravelAuthApp')->accessToken;
                $home_data = home_data::find(1);
                $data = [
                    'token' => $token,
                    'user' => UserResource::make($user),
                    'home data' => ($home_data) ? $home_data : null
                ];
                return $this->sendResponse(true, "The process is completed successfully", $data, 200);
            } else {
                return $this->sendResponse(false, "Invalid email/password", "", 400);
            }
        } catch (Exception $th) {
            return  $this->errorLog("AuthApiController@login", $th->getMessage());
        }
    }
    /*
        Defintion:
            user social login request (Facebook,Google,Apple)
        @Params:
            @param1 _  country_code
            @param2 _  phone
            @param3 _  email
            @param4 _  name
            @param5 _  image
            @param6 _  account_type
            @param7 _  account_id
        @Response:
            data
    */

    public function social_login(Request $request)
    {
        try {
            $validator = Validator::make($request->toArray(), [
                'account_type' => 'required',
                'account_id' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->sendResponse(false, "", $validator->getMessageBag(), 400);
            }

            // check account id
            $user = User::where('account_id', $request->account_id)->first();
            if ($user->status == 0) {
                return $this->sendResponse(false, "Your account is blocked.", "", 400);
            }
            // dd($user);
            // if account id not found request user data
            if ($user == null) {
                $validator = Validator::make($request->toArray(), [
                    'country_code' => 'required',
                    'phone' => 'required',
                    'email' => 'required',
                    'name' => 'required',
                    'image' => 'required'
                ]);
                if ($validator->fails()) {
                    return $this->sendResponse(false, "", $validator->getMessageBag(), 400);
                } else {
                    // do register proccess
                    $email = User::where('email', $request->email)->count();
                    if ($email > 0) {
                        return $this->sendResponse(false, "", "The email is already been taken", 400);
                    }
                    $phone_number = User::where('phone_number', $request->phone)->count();
                    if ($phone_number > 0) {
                        return $this->sendResponse(false, "", "The phone number is already been taken", 400);
                    }

                    $user = User::create([
                        'uuid' => UuidUuid::uuid4()->toString(),
                        'name' => $request->name,
                        'country_code' => $request->country_code,
                        'phone_number' => $request->phone,
                        'email' => $request->email,
                        'image' => $request->image,
                        'role' => 'User',
                        'account_id' => $request->account_id,
                        'password' => bcrypt("default_pass")
                    ]);
                    $tokenResult =  $user->createToken('authToken');
                    $response = [
                        'success' => "true",
                        'message' => "User created successfully",
                        "data" => array(
                            'token' =>  $tokenResult->accessToken,
                            'user' => UserResource::make($user)
                        )
                    ];

                    return response($response, 201);
                }
            } else {
                if ($request->email != null) {
                    $email = User::where('email', $request->email)->where('account_id', '!=', $user->account_id)->count();
                    if ($email > 0) {
                        return $this->sendResponse(false, "", "The email is already been taken", 400);
                    }
                }
                if ($request->phone != null) {
                    $phone_number = User::where('phone_number', $request->phone)->where('account_id', '!=', $user->account_id)->count();
                    if ($phone_number > 0) {
                        return $this->sendResponse(false, "", "The phone number is already been taken", 400);
                    }
                }
                isset($request->country_code) ?  $user->country_code = $request->country_code : null;
                isset($request->phone_number) ? $user->phone_number = $request->phone : null;
                isset($request->email) ? $user->email = $request->email : null;
                isset($request->name) ? $user->name = $request->name : null;
                isset($request->image) ? $user->image = $request->image : null;
                $user->role = 'User';
                isset($request->account_type) ? $user->account_type = $request->account_type : null;
                $user->save();

                ///////// generate token
                $token = $user->createToken('authToken')->accessToken;

                //////// send response
                $data = [
                    'token' => $token,
                    'user' => UserResource::make($user),
                ];
                return $this->sendResponse(true, "The process is completed successfully", $data, 200);
            }
        } catch (Exception $th) {
            return  $this->errorLog("AuthApiController@social_login", $th->getMessage());
        }

        // // $validator = Validator::make($request->toArray(), [
        // //     'phone' => 'exists:users,phone_number'
        // // ]);
        // if ($validator->fails()) {
        //     return $this->sendResponse(false, "", "Phone number is not found", 400);
        // } else {
        // }
    }
    public function gethomedata()
    {
        $home_data = home_data::find(1);
        try {
            if ($home_data) {
                $data = [
                    'about_en' => $home_data->about_en,
                    'about_ar' => $home_data->about_ar,
                    'terms_en' => $home_data->terms_en,
                    'terms_ar' => $home_data->terms_ar,
                    'privacy_policy_en' => $home_data->privacy_policy_en,
                    'privacy_policy_ar' => $home_data->privacy_policy_ar,
                    'contact_us_en' => $home_data->contact_us_en,
                    'contact_us_ar' => $home_data->contact_us_ar,
                    'email_us_en' => $home_data->email_us_en,
                    'email_us_ar' => $home_data->email_us_ar,
                ];
                return $this->sendResponse(true, "The Process Is Completed Successfully", $data, 200);
            } else {
                return $this->sendResponse(false, "", "Home Data Is Not Found", 400);
            }
        } catch (Exception $th) {
            return  $this->errorLog("AuthApiController@gethomedata", $th->getMessage());
        }
    }
}
