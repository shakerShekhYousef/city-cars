<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CarModel;
use App\Models\VehicleInformation;
use App\Models\DriverInformation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid as UuidUuid;


class VehicleInformationController extends Controller
{
    //
    public function index()
    {
    }
    public function edit($driverId)
    {
        $models = CarModel::get();
        $driverinformations = DriverInformation::where('driver_id', $driverId)->get();
        $vehicleinformation = VehicleInformation::where('driver_id', $driverId)->first();
        return view('pages.vehicleinformation.editvehicleinformation', ['vehicleinformation' => $vehicleinformation, 'models' => $models , 'driverinformations' => $driverinformations]);
    }

    public function update(Request $request, $driverId)
    {
        $request->validate([
            'drive_license_front_photo' => 'mimes:jpg,jpeg,png',
            'drive_license_back_photo' => 'mimes:jpg,jpeg,png',
            'no_criminal_record' => 'mimes:jpg,jpeg,png',
            'health_certificate' => 'mimes:jpg,jpeg,png',
            'id_photo' => 'mimes:jpg,jpeg,png',

        ]);

        $path = null;
        
        if ($request->file('drive_license_front_photo'))
            $path = $request->drive_license_front_photo->store('storage/documents/driver/cars_licenses');
        $path1 = null;
        if ($request->file('drive_license_back_photo'))
            $path1 = $request->drive_license_back_photo->store('storage/documents/driver/cars_licenses');
        $path2 = null;
        if ($request->hasFile('no_criminal_record')){
            $path2 = $request->no_criminal_record->store('storage/documents/driver/no_criminal');}
        $path3 = null;
        if ($request->file('health_certificate'))
            $path3 = $request->health_certificate->store('storage/documents/driver/health_certificates');
        $path4 = null;
        if ($request->file('id_photo'))
            $path4 = $request->id_photo->store('storage/documents/driver/ids');

        $driverinformation = DriverInformation::where('driver_id', $driverId)->first();
        $vehicleinformation = VehicleInformation::where('driver_id', $driverId)->first();
        $vehicleinformation->car_model = $request->car_model;
        if ($request->color_option != null)
            $vehicleinformation->car_color = $request->color_option;
            $vehicleinformation->save();

        if ($path != null)
            $driverinformation->drive_license_front_photo = $path;
        if ($path1 != null)
            $driverinformation->drive_license_back_photo = $path1;
        if ($path2 != null)
            $driverinformation->no_criminal_record = $path2;
            
        if ($path3 != null) 
            $driverinformation->health_certificate = $path3;
        if ($path4 != null)
            $driverinformation->id_photo = $path4;


        $driverinformation->save();
        return redirect()->route('vehicleinformationshow', $driverId)->with(['success' => 'Car information updated successfully']);
    }

    public function store(Request $request)
    {
    }

    public function show($driverId)
    {
        $driverinformations = DriverInformation::where('driver_id', $driverId)->get();

        $vehicleinformation = VehicleInformation::where('driver_id', $driverId)->first();
        if ($vehicleinformation != null)
            return view('pages.vehicleinformation.vehicleinformationshow', ['vehicleinformation' => $vehicleinformation ,'driverinformations' => $driverinformations]);
        else
            return redirect()->route('usersshow', $driverId)->with("error", "No vehicle information found");
    }


    public function delete($id)
    {
    }
}
