<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
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
       // return ServiceResource::Collection(Service::with('familles')->orderByDesc('id')->get());
       return ServiceResource::Collection(Service::with('familles')->get());
        
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
            'father' => 'required'

        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 400);
       }
        $service = Service::create($request->all());
     
        return response()->json([
            'message' => 'Service Created!',
            'service' =>new ServiceResource($service)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return new ServiceResource($service);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Service $service)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
            'father' => 'required', 
            'statut' => 'required', 


        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 400);
       }

       $service->name = $request->name;
       $service->father = $request->father;
       $service->statut = $request->statut;
       $service->save();

       return response()->json([
           'message' => 'Service updated!',
           'service' => $service
       ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();
        //return response()->json(null, 204);
        return response()->json([
            'message' => 'Service Deleted!',
            'service' => null
        ]);
    }
}
