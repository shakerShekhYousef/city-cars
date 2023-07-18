<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DashboardData;
use App\Models\User;
use App\Models\RideRequest;
use App\Models\Estimate;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Hamcrest\Type\IsNumeric;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid as UuidUuid;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class UserController extends Controller
{

    public function review(Request $request)
    {
        if ($request->ajax()) {
            $reviews = Review::join('users','reviews.user_id','=','users.uuid')->where('users.role','Driver')->get();
            // $users = User::where('role', 'Driver')->get();
            return Datatables::of($reviews)
                ->addIndexColumn()
                ->make(true);
        }
        return view('pages.users.listreviews');
    }

    public function driverprcentage(Request $request)
    {
        if ($request->post()) {
            $request->validate([
                'percentage' => 'required|max:100|min:0'
            ]);
            $perc = DashboardData::first()->update([
                'percentage' => $request->percentage
            ]);
            $percentage = DashboardData::first()->percentage;
            return redirect()->route('driverprcentage')->with('success', 'Driver percentage addedd successfully');
        }
        $percentage = DashboardData::first()->percentage;
        return view('pages.users.driverpercentage', ['percentage' => $percentage]);
    }
    //
    public function index(Request $request)
    {
        $users = User::all();
        if ($request->ajax()) {
            $data = User::select('uuid', 'name', 'email', 'country_code', 'phone_number', 'role', 'driver_credit', 'status','rate');
            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route('usersshow', $row->uuid) . ' class="btn btn-primary btn-sm">View</a>';

                    if (Auth::user()->role == 'Admin' && $row->role ==  'Driver') {
                        $btn .= '<a href=' . route('balanceedit', $row->uuid) . ' class="btn btn-info btn-sm m-2">Edit Balance</a>';
                    }
                    if (Auth::user()->role == 'Admin' && Auth::user()->uuid !=  $row->uuid) {
                        $btn .= "<button onclick=deleteUser('$row->uuid') class='btn btn-danger btn-sm m-2'>Delete</button>";
                    }
                    if (Auth::user()->role == 'Admin' && ($row->role == 'Driver' || $row->role == 'User')) {
                        if ($row->status == 1)
                            $btn .= '<a href=' . route('block_user', $row->uuid) . ' class="btn btn-danger btn-sm">Block User</a>';
                        else
                            $btn .= '<a href=' . route('block_user', $row->uuid) . ' class="btn btn-warning btn-sm">Unblock User</a>';
                    }

                    return $btn;
                })

                ->filter(function ($instance) use ($request) {
                    if ($request->get('role') !=  null) {
                        $instance->where('role', $request->get('role'));
                    }
                    if ($request->get('driver_credit') !=  null) {
                        $instance->where('driver_credit', $request->get('driver_credit'));
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('name', 'LIKE', "%$search%")
                                ->orWhere('email', 'LIKE', "%$search%")
                                ->orWhere('country_code', 'LIKE', "%$search%")
                                ->orWhere('role', 'LIKE', "%$search%")
                                ->orWhere('driver_credit', 'LIKE', "%$search%")
                                ->orWhere('phone_number', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.users.listusers', ['users' => $users]);
    }

    public function create()
    {
        return view('pages.users.userscreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'name' => 'required', 'string', 'max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:5|confirmed',
            // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // $path = null;
        // if ($request->hasFile('image')) {
        //     $path = $request->image->store('public/users/user_images');
        // }

        User::create([
            'uuid' => UuidUuid::uuid4()->toString(),
            // 'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request['password']),
            // 'country_code' => $request->country_code,
            // 'phone_number' => $request->phone_number,
            // 'image' => $path,
            'role' => "Admin"
        ]);
        return redirect()->route('userslist')
            ->with('success', 'user created successfully.');
    }

    public function show($uuid)
    {
        $user = User::where('uuid', $uuid)->get();
        return view('pages.users.usersshow', ['user' => $user]);
    }

    public function delete($id)
    {
        if (Auth::user()->uuid != $id) {
            DB::table('driver_information')->where('driver_id', $id)->delete();
            DB::table('vehicle_information')->where('driver_id', $id)->delete();
            DB::table('estimates')->where('user_id', $id)->delete();
            DB::table('cards')->where('driver_id', $id)->delete();
            DB::table('notifications')->where('sender', $id)->orWhere('receiver', $id)->delete();
            DB::table('reviews')->where('user_id', $id)->delete();
            DB::table('ride_requests')->where('user_id', $id)->orWhere('driver_id', $id)->delete();
            User::where('uuid', $id)->delete();
            return 1;
        } else {
            return 2;
        }
    }

    public function userverified(Request $request, $uuid)
    {
        $user = User::where('uuid', $uuid)->update(['user_verified' => $request->user_verified]);
        return back();
    }

    public function password_reset($token)
    {
        $email = DB::table('password_resets')->where('token', $token)->first();
        if ($email == null) {
            echo "Token is not valid";
            exit();
        }

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $email]
        );
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required',

        ]);

        $updatePassword = DB::table('password_resets')
            ->where(['email' => $request->email, 'token' => $request->token])
            ->first();

        if (!$updatePassword)
            return back()->withInput()->with('error', 'Invalid token!');

        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        //   return redirect('/login')->with('message', 'Your password has been changed!');
        echo "Password has been changed successfully";
        exit();
    }

    public function balanceedit($uuid)
    {
        $user = User::where('uuid', $uuid)->get();
        return view('pages.users.balanceedit', ['user' => $user]);
    }

    public function balanceupdate(Request $request, $uuid)
    {
        $request->validate([
            'driver_credit' =>  'required'
        ]);

        $user = User::where('uuid', $uuid)->first();
        $request->driver_credit != null ? $user->driver_credit = $request->driver_credit : null;
        $user->save();
        // send notification to driver
        $this->sendChangeBalanceNotificationToDriver($user->device_token);

        return redirect()->route('userslist')
            ->with('success', 'user Update successfully.');
    }

    public function block_user($user)
    {
        $user = User::find($user);
        if ($user) {
            if ($user->status == 1) {
                $user->status = 0;
                $user->save();

                $userTokens = $user->tokens;
                foreach ($userTokens as $token) {
                    $token->revoke();
                }
                return redirect()->route('userslist')
                    ->with('success', 'User blocked successfully.');
            } else if ($user->status == 0) {
                $user->status = 1;
                $user->save();

                return redirect()->route('userslist')
                    ->with('success', 'User unblocked successfully.');
            }
        }
    }

    public function tripreports(Request $request)
    {
        if ($request->ajax()) {
            $data = RideRequest::join('estimates', 'ride_requests.estimate_id', '=', 'estimates.uuid')
                ->join('users as users', 'users.uuid', '=', 'ride_requests.user_id')
                ->join('users as drivers', 'drivers.uuid', '=', 'ride_requests.driver_id')
                ->select(['users.name', 'drivers.name as drname', 'estimates.pickup_name', 'estimates.dropoff_name', 'estimates.distance_estimate', 'estimates.estimated_value', 'ride_requests.estimate_id'])->orderBy('ride_requests.created_at', 'desc');

            $percentage = DashboardData::first()->percentage;
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('Driver_Prcentage', function ($row) use ($percentage) {
                    $estimate = Estimate::find($row->estimate_id);
                    if ($estimate) {
                        $trip_price = $estimate != null ? $estimate->estimated_value : null;
                        if (is_numeric($trip_price)) {
                            $driverprcentage = $trip_price - ($percentage * $trip_price / 100);
                            return number_format($driverprcentage, 2);
                        }
                    }
                    return 0;
                })
                ->addColumn('Driver_Company_Prcentage', function ($row) use ($percentage) {
                    $estimate = Estimate::find($row->estimate_id);
                    if ($estimate) {
                        $trip_price =  $estimate->estimated_value;
                        if (is_numeric($trip_price)) {
                            $companyprcentage = $trip_price * ($percentage / 100);
                            return number_format($companyprcentage, 2);
                        }
                    }
                    return 0;
                })
                ->make(true);
        }
        return view('pages.tripreports.tripreports');
    }
}
