<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CarModel;
use App\Models\CarType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Validation\Validator;
use Illuminate\Support\Facades\File;
use DataTables;
use Ramsey\Uuid\Uuid as UuidUuid;


class CarModelController  extends Controller
{
    //
    public function index(Request $request)
    {
        $carmodels = CarModel::all();

        if ($request->ajax()) {
            $data = CarModel::select('uuid', 'name', 'car_type');
            return Datatables::of($data)->addIndexColumn()
                ->addIndexColumn()
                ->addColumn('car_type', function ($row) {
                    return $row->car_type_name();
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route('carmodelsedit', $row->uuid) . ' class="btn btn-primary btn-sm">Edit</a> ';
                    $btn .= "<button onclick=deleteCarModel('$row->uuid') class='btn btn-danger btn-sm'>Delete</button>";
                    return $btn;
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('name', 'LIKE', "%$search%")
                                ->orWhere('car_type', 'LIKE', "%$search%");
                        });
                    }
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.carmodels.listcarmodels', ['carmodels' => $carmodels]);
    }
    public function create()
    {
        $cartypes = CarType::get(['display_name', 'uuid']);


        return view('pages.carmodels.carmodelscreate', ['cartypes' => $cartypes]);
    }

    public function store(Request $request)
    {


        $request->validate([
            'name' => 'required', 'string', 'max:255',
            'car_type' => 'required',
        ]);
        CarModel::create([
            'uuid' => UuidUuid::uuid4()->toString(),
            'name' => $request->name,
            'car_type' => $request->car_type,


        ]);

        return redirect()->route('carmodelslist')
            ->with('success', 'carmodel created successfully.');
    }
    public function edit($uuid)
    {
        $carmodel = CarModel::where('uuid', $uuid)->get();
        $cartypes = CarType::get(['display_name', 'uuid']);

        return view('pages.carmodels.carmodelsedit', ['carmodel' => $carmodel, 'cartypes' => $cartypes]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $request->validate([

            'name' => 'required', 'string', 'max:255',
            'car_type' => 'required',


        ]);

        $carmodel = CarModel::where('uuid', $uuid)->first();


        $request->name != null ? $carmodel->name = $request->name : null;
        $request->car_type != null ? $carmodel->car_type = $request->car_type : null;

        $carmodel->save();

        return redirect()->route('carmodelslist')
            ->with('success', 'carmodel Update successfully.');
    }



    public function show($uuid)
    {

        $carmodel = CarModel::where('uuid', $uuid)->get();
        return view('pages.carmodels.carmodelshow', ['carmodel' => $carmodel]);
    }



    public function delete($id)
    {

        CarModel::where('uuid', $id)->delete();

        return redirect()->route('carmodelslist');
    }
}
