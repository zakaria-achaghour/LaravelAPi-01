<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExerciceResource;
use App\Models\Exercice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExerciceController extends Controller
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
        return ExerciceResource::Collection(Exercice::all());
        
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
            'year' => 'required|string', 
            'statut' => 'required', 

        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 400);
       }
        $exercice = Exercice::create($request->all());
     
        return response()->json([
            'message' => 'Exercice Created!',
            'exercice' =>new ExerciceResource($exercice)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Exercice $exercice)
    {
        return new ExerciceResource($exercice);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exercice $exercice)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|string', 
            'statut' => 'required', 

        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 400);
       }

       $exercice->year = $request->year;
       $exercice->statut = $request->statut;
       $exercice->save();

       return response()->json([
           'message' => 'Exercice updated!',
           'exercice' => $exercice
       ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exercice $exercice)
    {
        $exercice->delete();
        //return response()->json(null, 204);
        return response()->json([
            'message' => 'Exercice Deleted!',
            'exercice' => null
        ]);
    }
}
