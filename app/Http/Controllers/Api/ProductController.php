<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Fournisseur;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
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
        return ProductResource::Collection(Product::with(['fournisseurs','unity','famille'])->get());

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
            'famille' => 'required', 
            'fournisseurs' => 'required', 
            'unity' => 'required', 
            'lot_fournisseur' => 'required', 
            'date_peremption' => 'required',
            'statut' => 'required', 

        ]);
        
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 400);
       }
       // $product = product::create($request->all());
    //$service_id = Service::select('id')->where('name',$request->service)->value();
    //$fournisseursIds = Fournisseur::select('id')->whereIn('name',$request->fournisseurs)->get();

     $product = new Product();
     $product->name = $request->name;
     $product->sage = $request->sage;
     $product->min = $request->min;
     $product->max = $request->max;
     $product->prix_moyen = $request->prix;


     $product->famille_id = $request->famille;
     $product->unity_id = $request->unity;

     $product->lot_fournisseur = $request->lot_fournisseur;
     $product->date_peremption = $request->date_peremption;
     $product->statut = $request->statut;
     $product->save();
     $product->fournisseurs()->sync($request->fournisseurs);

      $product = Product::where('id',$product->id)->with(['fournisseurs','unity','famille'])->first();

        return response()->json([
            'message' => 'product Created!',
            'product' =>new productResource($product)
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
     $product = Product::where('id',$id)->with(['famille','fournisseurs','unity'])->first();
        return new productResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
            'famille' => 'required', 
            'fournisseurs' => 'required', 
            'unity' => 'required', 
            'lot_fournisseur' => 'required', 
            'date_peremption' => 'required',
            'statut' => 'required', 

        ]);
        
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 400);
       }

       $product->name = $request->name;
        $product->sage = $request->sage;
        $product->min = $request->min;
        $product->max = $request->max;
        $product->prix_moyen = $request->prix;


        $product->famille_id = $request->famille;
        $product->unity_id = $request->unity;

        $product->lot_fournisseur = $request->lot_fournisseur;
        $product->date_peremption = $request->date_peremption;
        $product->statut = $request->statut;
        $product->save();
        $product->fournisseurs()->sync($request->fournisseurs);

        $product = Product::where('id',$product->id)->with(['fournisseurs','unity','famille'])->first();

          return response()->json([
              'message' => 'product Updated!',
              'product' =>new productResource($product)
          ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::where('id',$id)->delete();
      
        return response()->json([
            'message' => 'Product deleted'
        ]);

    }
}
