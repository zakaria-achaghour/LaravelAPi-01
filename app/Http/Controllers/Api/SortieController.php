<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exercice;
use App\Models\Movement;
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
                $exerciceId =  $this->exerciceRepository->findId();


                /*cette requette affiche les articles li kayninn f stock o il mab9awch f stock o kaynine f sortie*/
                $famillesIds = $this->familleRepository->famillesIdsByUser();

              return  $products  = Movement::join('products','products.id','movements.product_id')
                                       //->Join('unities', 'unities.id','products.unity_id')
                                       ->select('products.name as product','products.id','products.famille_id',
                                       'products.sage','unity_id',DB::raw('sum(m.qte) as qte'),)
                                       ->with('products.famille','products.unity')
                                       ->whereIn('products.famille_id', $famillesIds)
                                       ->where('movements.qte', '<>',0)
                                       ->groupBy('products.name as product','products.id','products.famille_id', 'products.sage','unity_id')
                                       ->get();
 
                // $articles = DB::table('mouvments as m')
                //     ->Join('articles as a', 'a.id', '=', 'm.article_id')
                //     ->Join('familles as f', 'f.id', '=', 'a.famille_id ')
                //     ->Join('unites as u', 'u.id', '=', 'a.unite_id')
                //     ->select(
                //         'a.designation as article',
                //         'a.id as art_id',
                //         DB::raw('sum(m.qte) as qte'),
                //         'f.designation as famille',
                //         'a.code_sage as sage',
                //         'u.designation as unite',
                //         'f.inventaire',
                //         'f.active_exercice',
                //     )
                //     ->whereNull('a.deleted_at')
                //     ->where('m.qte', '<>',0)
                //     ->groupBy('a.designation','f.designation', 'a.id','f.active_exercice','f.inventaire', 'a.code_sage', 'u.designation','a.famille_id')
                //     ->havingraw('a.famille_id in'.$con)
                //     ->orderBy('qte', 'DESC')
                //     ->get();
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
        //
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
    public function destroy($id)
    {
        //
    }
}
