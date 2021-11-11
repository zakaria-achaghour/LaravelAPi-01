<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EntryResource;
use App\Models\Entry;
use App\Models\Exercice;
use App\Repositories\EntryRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EntryController extends Controller
{
    private $entryRepository;
    public function __construct(EntryRepository $entryRepository)
    {
        $this->middleware('auth:api');
        $this->entryRepository = $entryRepository;
    }

    public function findByProduct($id){
        $this->entryRepository->findByProduct($id);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       ///return EntrResource::Collection(Famille::with('service')->get());
        
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
         $year = Carbon::now()->format('Y');
         $exerciceId = Exercice::where('year', $year)->value('id');
         
        // store in entry
        $validator = Validator::make($request->all(), [
            'qte' => 'required',
            'prix_unitaire' => 'required', 
            'taux_change' => 'required', 
            'date_peremption' => 'required', 
            'date_reception' => 'required', 
            'lot_fournisseur' => 'required', 
            'bon_commande' => 'required', 
            'product' => 'required', 
            'currency' => 'required', 
            'user' => 'required', 
            'fournisseur' => 'required', 
            'unity' => 'required', 
            'cofe' => 'required' 
         ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 400);
       } 

       $entry = Entry::create($request->all());
     
       return response()->json([
           'message' => 'Entry Created!',
           'entry' =>new EntryResource($entry)
       ]);

        // $entree = new Entree();
        // $entree->qte = $request->input('qte');
        // $entree->prix_unitaire = $request->input('prix_unitaire');
        // $entree->taux_change = $request->input('taux_change');
        // $entree->date_peremption = $request->input('date_peremption');
        // $entree->date_reception = $request->input('date_reception');
        // $entree->lot_fournisseur = $request->input('lot_fournisseur');
        // $entree->bon_commande = $request->input('bon_commande');
        // $entree->article_id = $request->input('article');
        // $devie = $request->input('devis');


        // $entree->fournisseur_id = $request->input('fournisseur');
        // $entree->user_id = Auth::id();
        // $entree->unite_id = $request->input('unite');
        // $entree->cofe = $request->input('cofe');
        // $entree->exercice_id = $exerciceId;
        // $entree->save();

        // store in table Stock

        // $stock = new Stock();
        // $converter = UnitConverter::default();
        // $conversion = null;
        // if ($entree->article->unite->designation === "Unité" || $entree->article->unite->designation === "Boite") {
        //     $conversion = $entree->cofe * $entree->qte;
        // } else {
        //     $conversion = $converter->convert($entree->qte)->from($entree->unite->designation)->to($entree->article->unite->designation);
        // }
        // $prixunitaire = $entree->taux_change * $entree->prix_unitaire;
        // $cofe = $conversion / $entree->qte;

        // $entree->cofe = $cofe;
        // $entree->save();


        // $stock->qte_stock = $conversion;
        // $stock->prix_unitaire = $prixunitaire / $cofe;
        // $stock->entree_id = $entree->id;
        // $stock->article_id = $request->input('article');
        // $stock->save();

        // store in table Mouvement

        // $mouvement = new Mouvment();
        // $mouvement->action = "Entrée";
        // $mouvement->action_id = $entree->id;
        // $mouvement->article_id = $entree->article_id;
        // $mouvement->qte = $stock->qte_stock;
        // $mouvement->motif = '';
        // $mouvement->make_by = Auth::id();
        // $mouvement->exercice_id = $exerciceId;
        // $mouvement->save();
         
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
