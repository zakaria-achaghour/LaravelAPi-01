<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReceiverResource;
use App\Models\Receiver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReceiverController extends Controller
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
        return ReceiverResource::Collection(Receiver::with('service')->get());
        
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
            'service_id' => 'required', 
            'statut' => 'required', 

        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 400);
       }
        $receiver = Receiver::create($request->all());
        $receiver = Receiver::where('id',$receiver->id)->with('service')->first();

        return response()->json([
            'message' => 'receiver Created!',
            'receiver' =>new ReceiverResource($receiver)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $receiver = Receiver::where('id',$id)->with('service')->first();

        return new ReceiverResource($receiver);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receiver $receiver)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
            'service_id' => 'required', 
            'statut' => 'required', 

        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 400);
       }
   
     
        $receiver->name = $request->name;
        $receiver->statut = $request->statut;
        $receiver->service_id = $request->service_id;
        $receiver->save();
        $receiver = Receiver::where('id',$receiver->id)->with('service')->first();

        return response()->json([
            'message' => 'receiver Updated!',
            'receiver' =>new ReceiverResource($receiver)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receiver $receiver)
    {
        $receiver->delete();
        //return response()->json(null, 204);
        return response()->json([
            'message' => 'receiver Deleted!',
            'receiver' => null
        ]);
    }
}
