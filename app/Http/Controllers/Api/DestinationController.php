<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DestinationResource;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DestinationController extends Controller
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
        return DestinationResource::Collection(Destination::all());
        
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
            'statut' => 'required', 

        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 400);
       }
        $destination = Destination::create($request->all());
     
        return response()->json([
            'message' => 'Destination Created!',
            'destination' =>new DestinationResource($destination)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Destination $destination)
    {
        return new DestinationResource($destination);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Destination $destination)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
            'statut' => 'required', 

        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 400);
       }
       
     
        $destination->name = $request->name;
        $destination->statut = $request->statut;
        $destination->code = $request->code;
        $destination->save();
        return response()->json([
            'message' => 'Destination Updated!',
            'destination' =>new DestinationResource($destination)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Destination $destination)
    {
        $destination->delete();
        //return response()->json(null, 204);
        return response()->json([
            'message' => 'Destination Deleted!',
            'destination' => null
        ]);
    }
}
