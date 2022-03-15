<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FamilleResource;
use App\Models\Famille;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FamilleController extends Controller
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
        return FamilleResource::Collection(Famille::with('service')->get());
        
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
       // $famille = Famille::create($request->all());
    //$service_id = Service::select('id')->where('name',$request->service)->value();


     $famille = new Famille();
     $famille->name = $request->name;

     $famille->service_id =  $request->service_id;
     
     $famille->lot_fournisseur = $request->lot_fournisseur;
     $famille->date_peremption = $request->date_peremption;

     $famille->statut = $request->statut;
     $famille->save();
     $famille = Famille::where('id',$famille->id)->with('service')->first();

        return response()->json([
            'message' => 'Famille Created!',
            'famille' =>new FamilleResource($famille)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $famille)
    {
        $famille = Famille::where('id',$famille)->with('service')->first();
        return new FamilleResource($famille);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Famille $famille)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
            'service_id' => 'required', 
            'lot_fournisseur' => 'required', 
            'date_peremption' => 'required', 
            'statut' => 'required', 


        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 400);
       }

        $famille->name = $request->name;
        $famille->service_id = $request->service_id;
        $famille->lot_fournisseur = $request->lot_fournisseur;
        $famille->date_peremption = $request->date_peremption;

        $famille->statut = $request->statut;
        $famille->save();
        $famille = Famille::where('id',$famille->id)->with('service')->first();

       return response()->json([
           'message' => 'Famille updated!',
           'famille' => $famille
       ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Famille $famille)
    {
        $famille->delete();
        //return response()->json(null, 204);
        return response()->json([
            'message' => 'Famille Deleted!',
            'famille' => null
        ]);
    }
}
