<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
  public function index()
  {

    $users = User::get();

    return view('pages.notifications.lists', ['users' => $users]);
  }

  public function submit(Request $request)
  {
    $validator = Validator::make($request->toArray(), [
        'message' => 'required'
    ]);
    if ($validator->fails()) {
        return $validator->errors()->first();
    }

    try {
      $usersTokens = [];
      $type = 0;
      if ($request->user_select == 2) {
        $type = 1;
        $users_tokens = User::where('role', 'User')->get();
      } else if ($request->user_select == 3) {
        $type = 2;
        $drivers_tokens = User::where('role', 'Driver')->get();
      } else if ($request->user_select == 1) {
        $type = 3;
        if ($request->users != null) {
          $users_tokens = User::whereIn('uuid', $request->users)->where('role', 'user')->get();
          $drivers_tokens = User::whereIn('uuid', $request->users)->where('role', 'driver')->get();
        }
      }else if ($request->user_select == 4){
        $type = 4;
        $users_tokens = User::where('role', 'user')->get();
        $drivers_tokens = User::where('role', 'driver')->get();
      }
      if ($type == 1) {
        // users
        $data = [
          'type' => '1',
          'notification_type' => 'platform',
          'users_tokens' => $users_tokens
        ];
      } else if ($type == 2) {
        // drivers
        $data = [
          'type' => '2',
          'notification_type' => 'platform',
          'drivers_tokens' => $drivers_tokens
        ];
      } else if ($type == 3) {
        // custome
        if($request->users != null){
          $data = [
            'type' => '3',
            'notification_type' => 'platform',
            'drivers_tokens' => $drivers_tokens,
            'users_tokens' => $users_tokens
          ];
        }
        else{
          return "You should select users/drivers";
        }

      }elseif($type == 4){
        $data = [
            'type' => '4',
            'notification_type' => 'platform',
            'drivers_tokens' => $drivers_tokens,
            'users_tokens' => $users_tokens
          ];
      }

      $data['title'] = 'Admin Notification';
      $data['body'] = $request->message;
      $data['sender'] = Auth::user()->uuid;

      $result = $this->sendNotification($data);
      return $result;
    } catch (\Exception $th) {
    }
  }
}
