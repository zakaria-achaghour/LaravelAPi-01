<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SortieResource;
use App\Models\Exercice;
use App\Models\Movement;
use App\Models\Sortie;
use App\Repositories\ExerciceRepository;
use App\Repositories\FamilleRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SortieController extends Controller
{
    private $exerciceRepository;
    private $familleRepository;
    public function __construct(ExerciceRepository $exerciceRepository,FamilleRepository $familleRepository)
    {
        $this->middleware('auth:api');
        $this->exerciceRepository = $exerciceRepository;
        $this->familleRepository = $familleRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // stock + empthy or not 

                $exerciceId =  $this->exerciceRepository->findId();


                /*cette requette affiche les articles li kayninn f stock o il mab9awch f stock o kaynine f sortie*/
                $famillesIds = $this->familleRepository->famillesIdsByUser();

              return  $products  = Movement::join('products','products.id','movements.product_id')
                                       ->Join('unities', 'unities.id','products.unity_id')
                                       ->Join('familles', 'familles.id','products.famille_id')

                                       ->select('products.name as product','products.id','familles.name as famille',
                                       'products.sage','unities.name as unity',DB::raw('sum(movements.qte) as qte'),)
                                       
                                       ->whereIn('products.famille_id', $famillesIds)
                                       ->where('movements.qte', '<>',0)
                                       ->groupBy('products.name','products.id','familles.name', 'products.sage','unities.name')
                                       ->get();

}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // detail for product  sorties
        $sorties = Sortie::where('product_id',$id)->with(['product','product.famille','unity','receiver','destination'])->orderByDesc('id')->get();
       
        return  SortieResource::Collection($sorties);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sortie $sortie)
    {
        // $sortie->delete();
        // return response()->json([
        //     'message' => 'Sortie deleted'
        // ]);
    }
}
