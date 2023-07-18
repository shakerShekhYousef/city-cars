<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CarType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Validation\Validator;
use Illuminate\Support\Facades\File;
use DataTables;
use Ramsey\Uuid\Uuid as UuidUuid;


class CarTypeController extends Controller
{
    //
    public function index(Request $request)
    {
        $cartypes = CarType::all();

        if ($request->ajax()) {
            $data = CarType::select('uuid', 'display_name', 'capacity', 'image');
            return Datatables::of($data)->addIndexColumn()
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<a href=' . asset($row->image) . ' target="blank"><img src="' . asset($row->image) . '" alt="" width="150" height="150"></a>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route('cartypesedit', $row->uuid) . ' class="btn btn-primary btn-sm">Edit</a> ';
                    $btn .= "<button onclick=deleteCarType('$row->uuid') class='btn btn-danger btn-sm'>Delete</button>";
                    return $btn;
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('display_name', 'LIKE', "%$search%")
                                ->orWhere('capacity', 'LIKE', "%$search%")
                                ->orWhere('image', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }
        return view('pages.cartypes.listcartypes', ['cartypes' => $cartypes]);
    }
    public function create()
    {
        return view('pages.cartypes.cartypescreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'display_name' => 'required', 'string', 'max:255',
            'capacity' => 'required', 'string',
            'description' =>  'string',
            'image' => 'required|mimes:png,jpg,jpeg'
        ]);

        $path = $request->image->store('storage/cartypes');

        CarType::create([
            'uuid' => UuidUuid::uuid4()->toString(),
            'display_name' => $request->display_name,
            'capacity' => $request->capacity,
            'cost_per_minute' => $request->cost_per_minute,
            'cost_per_km' => $request->cost_per_km,
            'cancellation_fee' => $request->cancellation_fee,
            'image' => $path,
            'initial_fee' =>  $request->initial_fee,
            'description' =>  $request->description
        ]);

        return redirect()->route('cartypeslist')
            ->with('success', 'cartype created successfully.');
    }
    public function edit($uuid)
    {
        $cartype = CarType::where('uuid', $uuid)->get();
        return view('pages.cartypes.cartypesedit', ['cartype' => $cartype]);
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
        $cartype = CarType::where('uuid', $uuid)->first();

        $request->display_name != null ? $cartype->display_name = $request->display_name : null;
        $request->capacity != null ? $cartype->capacity = $request->capacity : null;
        $request->cost_per_minute != null ? $cartype->cost_per_minute = $request->cost_per_minute : null;
        $request->cost_per_km != null ? $cartype->cost_per_km = $request->cost_per_km : null;
        $request->cancellation_fee != null ? $cartype->cancellation_fee = $request->cancellation_fee : null;
        $request->initial_fee != null ? $cartype->initial_fee = $request->initial_fee : null;
        $request->description != null ? $cartype->description = $request->description : null;
        
        if ($request->has('image')) {
            $path = $request->image->store('storage/cartypes');
            $cartype->image = $path;
        }

        $cartype->save();

        return redirect()->route('cartypeslist')
            ->with('success', 'cartype Update successfully.');
    }



    public function show($uuid)
    {

        $cartype = CarType::where('uuid', $uuid)->get();
        return view('pages.cartypes.cartypesshow', ['cartype' => $cartype]);
    }



    public function delete($id)
    {

        CarType::where('uuid', $id)->delete();

        return redirect()->route('cartypeslist');
    }
}
