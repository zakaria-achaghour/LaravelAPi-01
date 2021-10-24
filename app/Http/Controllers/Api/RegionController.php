<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegionResource;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegionController extends Controller
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
        return RegionResource::Collection(Region::all());
        
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
            return response()->json(['error'=>$validator->errors()], 400);
       }
        $region = Region::create($request->all());
     
        return response()->json([
            'message' => 'region Created!',
            'region' =>new RegionResource($region)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Region $region)
    {
        return new RegionResource($region);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {   
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
       }
        $region->name = $request->name;
        $region->save();
        return response()->json([
            'message' => 'Region updated!',
            'region' => $region
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Region $region)
    {
        $region->delete();
        //return response()->json(null, 204);
        return response()->json([
            'message' => 'Region Deleted!',
            'region' => null
        ]);
}
}
