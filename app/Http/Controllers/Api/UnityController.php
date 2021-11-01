<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UnityResource;
use App\Models\Unity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnityController extends Controller
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
       return UnityResource::Collection(Unity::all());
        
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
        $unity = Unity::create($request->all());
     
        return response()->json([
            'message' => 'unity Created!',
            'unity' =>new UnityResource($unity)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Unity $unity)
    {
        return new UnityResource($unity);
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
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 400);
       }
       $unity = Unity::where('id', $id)->update(['name' => $request->name]);
    
      
        return response()->json([
            'message' => 'unity Updated!',
            'unity' =>new UnityResource($unity)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unity $unity)
    {
        $unity->delete();
        //return response()->json(null, 204);
        return response()->json([
            'message' => 'unity Deleted!',
            'unity' => null
        ]);
    }
}
