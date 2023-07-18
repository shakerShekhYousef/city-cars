<?php

namespace App\Http\Controllers;

use App\Models\home_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\type;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        return view('home');
    }
    public function about(){
        $about=home_data::find(1);
        return view('pages.homeContent.about',compact('about'));
    }
    public function aboutupdate(Request $request){
        $validator = Validator::make($request->toArray(), [
            'about_ar' => 'required',
            'about_en' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error'=>$validator->errors()->all(),
                'status'=>false
            ]);
        }
        $home_data=home_data::find(1);
        if($home_data){
            $home_data->update([
                'about_ar' => $request->about_ar,
                'about_en' => $request->about_en
            ]);
        }else{
            home_data::create([
                'about_en'=>$request->about_en,
                'about_ar'=>$request->about_ar,
            ]);
        }
        return response()->json([
            'message'=>'Update About Successfully',
            'status'=>true
        ]);
    }
    public function terms(){
        $terms=home_data::find(1);
        return view('pages.homeContent.terms',compact('terms'));
    }
    public function termsupdate(Request $request){
        $validator = Validator::make($request->toArray(), [
            'terms_ar' => 'required',
            'terms_en' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'error'=>$validator->errors()->all(),
                'status'=>false
            ]);
        }
        $home_data=home_data::find(1);
        if($home_data){
            $home_data->update([
                'terms_ar' => $request->terms_ar,
                'terms_en' => $request->terms_en
            ]);
        }
        else{
            home_data::create([
                'terms_en'=>$request->terms_en,
                'terms_ar'=>$request->terms_ar,
            ]);
        }
        return response()->json([
            'message'=>'Update Terms Successfully',
            'status'=>true
        ]);
    }
    public function privacypolicy(){
        $privacypolicy=home_data::find(1);
        return view('pages.homeContent.privacypolicy',compact('privacypolicy'));
    }
    public function privacypolicyupdate(Request $request){
        $validator = Validator::make($request->toArray(), [
            'privacy_policy_ar' => 'required',
            'privacy_policy_en' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'error'=>$validator->errors()->all(),
                'status'=>false
            ]);
        }
        $home_data=home_data::find(1);
        if($home_data){
            $home_data->update([
                'privacy_policy_ar' => $request->privacy_policy_ar,
                'privacy_policy_en' => $request->privacy_policy_en
            ]);
        }else{
            home_data::create([
                'privacy_policy_en'=>$request->privacy_policy_en,
                'privacy_policy_ar'=>$request->privacy_policy_ar,
            ]);
        }
        return response()->json([
            'message'=>'Update Privacy Policy Successfully',
            'status'=>true
        ]);
    }
    public function contactus(){
        $contactus=home_data::find(1);
        return view('pages.homeContent.contactus',compact('contactus'));
    }
    public function contactusupdate(Request $request){
        $validator = Validator::make($request->toArray(), [
            'contact_us_ar' => 'required',
            'contact_us_en' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'error'=>$validator->errors()->all(),
                'status'=>false
            ]);
        }
        $home_data=home_data::find(1);
        if($home_data){
            $home_data->update([
                'contact_us_ar' => $request->contact_us_ar,
                'contact_us_en' => $request->contact_us_en
            ]);
        }else{
            home_data::create([
                'contact_us_en'=>$request->contact_us_en,
                'contact_us_ar'=>$request->contact_us_ar,
            ]);
        }
        return response()->json([
            'message'=>'Update Contact Us Successfully',
            'status'=>true
        ]);
    }
    public function emailus(){
        $emailus=home_data::find(1);
        return view('pages.homeContent.emailus',compact('emailus'));
    }
    public function emailusupdate(Request $request){
        $validator = Validator::make($request->toArray(), [
            'email_us_ar' => 'required',
            'email_us_en' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'error'=>$validator->errors()->all(),
                'status'=>false
            ]);
        }
        $home_data=home_data::find(1);
        if($home_data){
            $home_data->update([
                'email_us_ar' => $request->email_us_ar,
                'email_us_en' => $request->email_us_en
            ]);
        }else{
            home_data::create([
                'email_us_en'=>$request->email_us_en,
                'email_us_ar'=>$request->email_us_ar,
            ]);
        }
        return response()->json([
            'message'=>'Update Email Us Successfully',
            'status'=>true
        ]);

    }


}
