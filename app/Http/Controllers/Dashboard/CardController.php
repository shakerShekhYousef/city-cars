<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\File;
use DataTables;
use Ramsey\Uuid\Uuid as UuidUuid;


class CardController extends Controller
{
    //
    public function index(Request $request)
    {
        $cards = Card::all();

        if ($request->ajax()) {
            $data = Card::select('code', 'price','is_used');
            return Datatables::of($data)->addIndexColumn()
                ->addIndexColumn()
               
                ->addColumn('is_used', function ($row) {
                    if ($row->is_used=='0')
                   {
                    return '<a href=' .  ($row->code). ' class="btn btn-success btn-sm disabled ">not Used</a> ';}
                    elseif($row->is_used=='1'){
                        return '<a href=' .  ($row->code). ' class="btn btn-danger btn-sm disabled ">Used</a> ';
 
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route('cardsedit', $row->code) . ' class="btn btn-primary btn-sm">Edit</a> ';
                    $btn .= "<button onclick=deleteCard('$row->code') class='btn btn-danger btn-sm'>Delete</button>";
                    return $btn;
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('code', 'LIKE', "%$search%")
                                ->orWhere('price', 'LIKE', "%$search%");
                                
                        });
                    }
                })
                ->rawColumns(['action','is_used'])
                ->make(true);
        }
        return view('pages.cards.listcards', ['cards' => $cards]);
    }
    public function create()
    {
        return view('pages.cards.cardscreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'price' =>  'required',
        
           
        ]);

 

        Card::create([
            'code' =>  random_int(100000000000000, 999999999999999),
            'price' => $request->price,
         
        ]);

        return redirect()->route('cardslist')
            ->with('success', 'card created successfully.');
    }
    public function edit($code)
    {
        $card = Card::where('code', $code)->get();
        return view('pages.cards.cardsedit', ['card' => $card]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $code)
    
    {

        $request->validate([
            'price' =>  'required',
        
           
        ]);


        $card = Card::where('code', $code)->first();

        $request->price != null ? $card->price = $request->price : null;
   

        $card->save();

        return redirect()->route('cardslist')
            ->with('success', 'card Update successfully.');
    }



    public function show($code)
    {

        $card = Card::where('code', $code)->get();
        return view('pages.cards.cardsshow', ['card' => $card]);
    }



    public function delete($id)
    {

        Card::where('code', $id)->delete();

        return redirect()->route('cardslist');
    }
}
