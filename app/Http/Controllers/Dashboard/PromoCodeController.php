<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\File;
use DataTables;
use Ramsey\Uuid\Uuid as UuidUuid;


class PromoCodeController extends Controller
{
    //
    public function index(Request $request)
    {
        $promocodes = PromoCode::all();

        if ($request->ajax()) {
            $data = PromoCode::select('id','promo_code', 'type','value','expiry_date','usage_limit','users_number','status');
            return Datatables::of($data)->addIndexColumn()
                ->addIndexColumn()
                   
                ->addColumn('status', function ($row) {
                    $currentDate = \Carbon\Carbon::today();
                    $date = new \Carbon\Carbon($row->expiry_date);
                    if ($date < $currentDate || $row->users_number >= $row->usage_limit)
                   {
                    return '<a href=' .  ($row->id). ' class="btn btn-danger btn-sm disabled ">invalid</a> ';
                }
                
                    else{
                        return '<a href=' .  ($row->id). ' class="btn btn-success btn-sm disabled ">valid</a> ';
 
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route('promocodesedit', $row->id) . ' class="btn btn-primary btn-sm">Edit</a> ';
                    $btn .= "<button onclick=deletePromoCode('$row->id') class='btn btn-danger btn-sm'>Delete</button>";
                    return $btn;
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('promo_code', 'LIKE', "%$search%")
                            ->orWhere('type', 'LIKE', "%$search%")
                            ->orWhere('value', 'LIKE', "%$search%")
                            ->orWhere('expiry_date', 'LIKE', "%$search%")
                            ->orWhere('expiry_date', 'LIKE', "%$search%")

                            ->orWhere('users_number', 'LIKE', "%$search%");
                                
                        });
                    }
                })
                ->rawColumns(['action','status'])
                ->make(true);
        }
        return view('pages.promocodes.listpromocodes', ['promocodes' => $promocodes]);
    }
    public function create()
    {
        return view('pages.promocodes.promocodescreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'promo_code' =>  'required',
            'type' =>  'required',
            'value' =>  'required',
             'expiry_date' =>  'required',
            'usage_limit' =>  'required',
        ]);

        PromoCode::create([
            'promo_code' => $request->promo_code,
            'type' => $request->type,
            'value' => $request->value,
            'expiry_date' => $request->expiry_date,
            'usage_limit' => $request->usage_limit,

         
        ]);

        return redirect()->route('promocodeslist')
            ->with('success', 'Promo Code created successfully.');
    }
    public function edit($id)

    {
        $promocode = PromoCode::where('id', $id)->get();
        return view('pages.promocodes.promocodesedit', ['promocode' => $promocode]);
    }
    
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    
    {

        $request->validate([
            'promo_code' =>  'required',
            'type' =>  'required',
            'value' =>  'required',
            'expiry_date' =>  'required',
            'usage_limit' =>  'required',
            
        
           
        ]);

        $promocode = PromoCode::where('id', $id)->first();


        $request->promo_code != null ? $promocode->promo_code = $request->promo_code : null;
        $request->type != null ? $promocode->type = $request->type : null;
        $request->value != null ? $promocode->value = $request->value : null;
        $request->expiry_date != null ? $promocode->expiry_date = $request->expiry_date : null;
        $request->usage_limit != null ? $promocode->usage_limit = $request->usage_limit : null;


        $promocode->save();

        return redirect()->route('promocodeslist')
            ->with('success', 'Promo Code Update successfully.');
    }



    public function show($id)
    {

        $promocode = PromoCode::where('id', $id)->get();
        return view('pages.promoscode.promocodesshow', ['promocode' => $promocode]);
    }



    public function delete($id)
    {

        PromoCode::where('id', $id)->delete();

        return redirect()->route('promocodeslist');
    }
}
