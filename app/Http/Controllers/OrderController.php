<?php

namespace App\Http\Controllers;

use App\Medicine;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medicines=Medicine::all();
        return view('orders.index',compact('medicines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveBill(Request $request)
    {
        $med=Medicine::find($request->id);
        $med->quantity=$med->quantity-1;
        $med->save();
        return response()->json($med);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
//        $medicines=Medicine::where('quantity','<',2)->get();
//        return view('medicines.index',compact('medicines'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function edit(Medicine $medicine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
//    public function update(Request $request, $id)
//    {
//        $medicine=Medicine::find($id);
//        $medicine->update($request->all());
//        return response()->json($medicine);
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
//    public function destroy($id)
//    {
//        if (Medicine::destroy($id))
//            return response()->json($id);
//
//        return response()->json(['failed Deleted']);
//    }

}
