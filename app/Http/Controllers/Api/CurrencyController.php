<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyResource;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CurrencyResource::Collection(Currency::all());
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
       }
       $currency = new Currency();
        $currency->name = $request->name;
        $currency->save();
        return response()->json([
            'message' => 'currency Created!',
            'currency' => $currency
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        return new CurrencyResource($currency);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Currency $currency)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
       }
        $currency->name = $request->name;
        $currency->save();
        return response()->json([
            'message' => 'currency updated!',
            'currency' => $currency
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();
        //return response()->json(null, 204);
        return response()->json([
            'message' => 'currency Deleted!',
            'currency' => null
        ]);
    }
}
