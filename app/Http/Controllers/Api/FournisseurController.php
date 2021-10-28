<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FournisseurResource;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FournisseurController extends Controller
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
        return FournisseurResource::Collection(Fournisseur::all());
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
        $fournisseur = Fournisseur::create($request->all());
     
        return response()->json([
            'message' => 'Fournisseur Created!',
            'fournisseur' =>new FournisseurResource($fournisseur)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Fournisseur $fournisseur)
    {
        return new FournisseurResource($fournisseur);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Fournisseur $fournisseur)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 400);
       }
       $fournisseur->sage = $request->sage;
       $fournisseur->motif = $request->motif;
       $fournisseur->statut = $request->statut;
       $fournisseur->name = $request->name;
       $fournisseur->save();
       return response()->json([
           'message' => 'Fournisseur updated!',
           'fournisseur' => $fournisseur
       ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();
        //return response()->json(null, 204);
        return response()->json([
            'message' => 'Fournisseur Deleted!',
            'fournisseur' => null
        ]);
    }
}