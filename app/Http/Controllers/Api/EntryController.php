<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EntryResource;
use App\Models\Entry;
use App\Models\Exercice;
use App\Models\Movement;
use App\Models\Stock;
use App\Repositories\EntryRepository;
use App\Repositories\ExerciceRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EntryController extends Controller
{
    private $entryRepository;
    private $exerciceRepository;

    public function __construct(EntryRepository $entryRepository, ExerciceRepository $exerciceRepository)
    {
        $this->middleware('auth:api');
        $this->entryRepository = $entryRepository;
        $this->exerciceRepository = $exerciceRepository;

    }

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //return EntrResource::Collection(Famille::with('service')->get());
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

         //  /** get the id of exercice */
         $exerciceId =  $this->exerciceRepository->findId();
         
        // store in entry
        $validator = Validator::make($request->all(), [
            'qte' => 'required',
            'prix_unitaire_achat' => 'required', 
            'taux_change' => 'required', 
           // 'date_peremption' => 'required', 
            'date_reception' => 'required', 
            //'lot_fournisseur' => 'required', 
            'bon_commande' => 'required', 
            'product' => 'required', 
            'currency' => 'required', 
            'fournisseur' => 'required', 
            'unity' => 'required', 
            'cofe' => 'required' ,
            'qteStock' => 'required',
            'prix_unitaire_stock'=>'required'
         ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 400);
       } 
      
       $entry = new Entry();
       $entry->qte = $request->qte;
       $entry->prix_unitaire = $request->prix_unitaire_achat;
       $entry->taux_change = $request->taux_change;
       $entry->date_peremption = $request->date_peremption;
       $entry->date_reception = $request->date_reception;
       $entry->lot_fournisseur = $request->lot_fournisseur;
       $entry->bon_commande = $request->bon_commande;
       $entry->product_id = $request->product;
       $entry->currency_id = $request->currency;
       $entry->fournisseur_id = $request->fournisseur;
       $entry->user_id = Auth::id();
       $entry->unity_id = $request->unity;
       $entry->cofe = $request->cofe;
       $entry->exercice_id = $exerciceId;
       $entry->save();

       //$entry = Entry::create($request->all());
     
      
       

        // store in table Stock

        $stock = new Stock();
        $stock->qte_stock = $request->qteStock;
        $stock->prix_unitaire = $request->prix_unitaire_stock;
        $stock->entry_id = $entry->id;
        $stock->product_id = $request->product;
        $stock->save();

        // store in table movement

        $movement = new Movement();
        $movement->action = "Entry";
        $movement->action_id = $entry->id;
        $movement->product_id = $request->product;;
        $movement->qte = $stock->qte_stock;
        $movement->motif = '';
        $movement->make_by = Auth::id();
        $movement->exercice_id = $exerciceId;
        $movement->save();
       $entry =  Entry::with(['product','fournisseur','unity','currency','user'])->where('id',$entry->id)->first();
        return response()->json([
            'message' => 'Entry Created!',
            'entry' =>new EntryResource($entry)
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
    public function destroy(Entry $entry)
    {
        $exerciceId =  $this->exerciceRepository->findId();
        $stock = Stock::where('entry_id', $entry->id)->first();
        // $sortie = DB::table('sortie_detail')->where('entry_id', $entry->id)->count();

        // if ($sortie > 0) {
        //     return response()->json([
        //         'error' => true,
        //         'message' => "Entrée déjà  Consommé",
        //     ]);
        // }

       $stock->delete();
       $entry->delete();

            $action = 'Entry';

        if ($entry->bon_commande === 'Diverse') {
            $action = 'Entry Diverse';
        }
        $movement = new Movement();
        $movement->action = $action;
        $movement->action_id = $entry->id;
        $movement->product_id = $entry->product_id;;
        $movement->qte = -$stock->qte_stock;
        $movement->motif = 'Retour';
        $movement->make_by = Auth::id();
        $movement->exercice_id = $exerciceId;
        $movement->save();

      

        return response()->json([
          
            'message' => "Entry deleted ",
        ]);
       
    }

    public function entriesByProduct($id){

       return EntryResource::Collection(Entry::with(['product','fournisseur','unity','currency','user'])->where('product_id',$id)->orderByDesc('id')->get());
    }
    public function entriesByFournisseur($id){

        return EntryResource::Collection(Entry::with(['product','fournisseur','unity','currency','user'])->where('fournisseur_id',$id)->orderByDesc('id')->get());
     }
}
