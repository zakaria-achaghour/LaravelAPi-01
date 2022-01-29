<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SortieResource;
use App\Models\Entry;
use App\Models\Exercice;
use App\Models\Movement;
use App\Models\Sortie;
use App\Models\Stock;
use App\Repositories\ExerciceRepository;
use App\Repositories\FamilleRepository;
use App\Repositories\StockRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SortieController extends Controller
{
    private $exerciceRepository;
    private $familleRepository;
    private $stockRepository;
    public function __construct(ExerciceRepository $exerciceRepository,FamilleRepository $familleRepository,StockRepository $stockRepository)
    {
        $this->middleware('auth:api');
        $this->exerciceRepository = $exerciceRepository;
        $this->familleRepository = $familleRepository;
        $this->stockRepository = $stockRepository;

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
          
           // store in entry
           $validator = Validator::make($request->all(), [
               'qte' => 'required', 
               'consommation_date' => 'required', 
               'receiver' => 'required', 
               'destination' => 'required', 
               'product' => 'required', 
               'unity' => 'required', 
               'famille' => 'required', 
            ]);
   
           if($validator->fails()){
               return response()->json(['error'=>$validator->errors()], 400);
          } 

           //  /** get the id of exercice */
           $exerciceId =  $this->exerciceRepository->findId();
        
          // store in sortie
          $sortie = new Sortie();
          $sortie->qte = $request->qte;
          $sortie->unity_id = $request->unity;
          $sortie->famille_id = $request->famille;
          $sortie->user_id = Auth::id();
          $sortie->product_id = $request->product;
          $sortie->date_consommation = $request->consommation_date;
          $sortie->receiver_id = $request->receiver;
          $sortie->destination_id = $request->destination;
          $sortie->exercice_id = $exerciceId;
          $sortie->observation = $request->observation;
          $sortie->save();

        // store in table movement

        $movement = new Movement();
        $movement->action = "Sortie";
        $movement->action_id = $sortie->id;
        $movement->product_id = $request->product;
        $movement->qte = -$request->qte;
        $movement->motif = '';
        $movement->make_by = Auth::id();
        $movement->exercice_id = $exerciceId;
        $movement->save();


       

        $qteDeleted = $request->qte;
        do {
            //dd($qteDeleted);
            $stocks =$this->stockRepository->findByProductExperationDate($request->product);
            if(count($stocks) == 0){
                $stocks = $this->stockRepository->findByProductReceptionDate($request->product);
            }

            $stock = Stock::find($stocks[0]->stock_id);
            foreach($stocks as $s){
                if($s->entamer == 1){
                    //dd('entamer');
                    $stock = Stock::where('id', $s->stock_id)->first();
                }
            }

            if ($stock->qte_stock >= $qteDeleted) { 
                    $stock->qte_stock = $stock->qte_stock - $qteDeleted;
                    $qteDeleted = 0;
            }else{
                $qteDeleted = $qteDeleted - $stock->qte_stock;
                $stock->qte_stock = 0;
            }

            DB::table('sortie_detail')->insert(['entry_id'=>$stock->entry_id,'sortie_id'=>$sortie->id,'exercice_id'=>$exerciceId,'qte'=>$qteDeleted,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            $stock->entamer = 1;
            $stock->save();
            Stock::where('qte_stock', 0)->delete();
          } while ($qteDeleted > 0 );
       

          $sortie =  Sortie::with(['product','unity','famille','user','receiver','destination'])->where('id',$sortie->id)->first();
          return response()->json([
              'message' => 'Sortie Created!',
              'sortie' =>new SortieResource($sortie)
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

        $exerciceId =  $this->exerciceRepository->findId();
       $sortie_detail = DB::table('sortie_detail')
           ->select('entry_id', 'qte')
           ->where('sortie_id', $sortie->id)
           ->where('deleted_at', Null)
           ->get();

       foreach ($sortie_detail as $sd) {
           $entry = Entry::where('id',$sd->entry_id)->first();
           $stock = Stock::where('entry_id', $sd->entry_id)->first();
           if ($stock != Null) {
               $stock->qte_stock = $stock->qte_stock + $sd->qte ;
               if($stock->qte_stock == $entry->qte){
                   $stock->entamer = 0;
               }
               $stock->save();
           } else {
               
               $new_stock = new Stock();
               if($entry->prix_unitaire <> 0){
                   $prixunitaire = $entry->taux_change * $entry->prix_unitaire;
               }else{
                   $prixunitaire = DB::table('products')->where('id', $entry->product_id)->value('prix_moyen');
               }
               $new_stock->qte_stock = $sd->qte;
               $new_stock->prix_unitaire = $prixunitaire;
               $new_stock->entry_id = $entry->id;
               $new_stock->product_id = $sortie ->product_id;
               $new_stock->save();
           }
       }
       $movement = new Movement();
       $movement->action = "Sortie";
       $movement->action_id = $sortie->id;
       $movement->product_id = $sortie->product_id;
       $movement->qte = -$sortie->qte;
       $movement->motif = 'Annulation';
       $movement->make_by = Auth::id();
       $movement->exercice_id = $exerciceId;
       $movement->save();


       DB::table('sortie_detail')->where('sortie_id', $sortie->id)->update(['deleted_at'=>Carbon::now()]);
       $sortie->delete();
      
        return response()->json([
            'message' => 'Sortie deleted'
        ]);
    }

    public function sortieEntryCount($id) {
        return response()->json([
            'countSortieByEntry' => DB::table('sortie_detail')->where('entry_id', $id)->count()
        ]);
       // return DB::table('sortie_detail')->where('entry_id', $id)->count();

    }
}
