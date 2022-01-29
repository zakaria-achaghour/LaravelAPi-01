<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Repositories\FamilleRepository;
use App\Repositories\ProductRepository;
use App\Repositories\StockRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{

    private $productRepository;
    private $familleRepository;
    private $stockRepository;
    public function __construct(ProductRepository $productRepository,FamilleRepository $familleRepository,StockRepository $stockRepository)
    {
        $this->middleware('auth:api');
        $this->productRepository = $productRepository;
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
        
        // $stocks = DB::table('stocks')
        //     ->Join('products', 'products.id', 'stocks.product_id')
        //     ->Join('familles', 'familles.id', 'products.famille_id')
        //     ->leftJoin('entries', 'entries.id', 'stocks.entry_id')
        //     ->leftJoin('fournisseurs', 'fournisseurs.id', 'entries.fournisseur_id')
        //     ->join('unities', 'unities.id', 'products.unity_id')
        //     ->join('famille_user', 'famille_user.famille_id', 'familles.id')
        //     ->select(
        //         'products.id',
        //         'familles.name as famille',
        //         'products.name as product',
        //         'unities.name as unity',
                
        //         'familles.inventaire',
        //         DB::raw('sum(stocks.qte_stock) as qte'),
        //         DB::raw('sum(stocks.qte_stock * stocks.prix_unitaire) as valeur')
        //     )
        //     ->where('famille_user.user_id', Auth::id())
        //     ->groupBy('products.id', 'familles.name', 'familles.inventaire', 'products.name', 'unities.name')

        //     ->get();
        
        $ids = $this->familleRepository->famillesIdsByUser();
        $productsIds = $this->productRepository->productsIDsByFamilles($ids);

         $stocks = Stock::Join('products', 'products.id', 'stocks.product_id')
            ->Join('familles', 'familles.id', 'products.famille_id')
            ->leftJoin('entries', 'entries.id', 'stocks.entry_id')
            ->leftJoin('fournisseurs', 'fournisseurs.id', 'entries.fournisseur_id')
            ->join('unities', 'unities.id', 'products.unity_id')
            ->select(
                'products.id',
                'familles.name as famille',
                'products.name as product',
                'unities.name as unity',
                'familles.inventaire',
                DB::raw('sum(stocks.qte_stock) as qte'),
                DB::raw('sum(stocks.qte_stock * stocks.prix_unitaire) as valeur'))
            ->whereIn('products.id', $productsIds)
            ->groupBy('products.id', 'familles.name', 'familles.inventaire', 'products.name', 'unities.name')
            ->get();



        return $stocks;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stocks = Stock::Join('products', 'products.id', 'stocks.product_id')
        ->Join('familles', 'familles.id', 'products.famille_id')
        ->leftJoin('entries', 'entries.id', 'stocks.entry_id')
        ->leftJoin('fournisseurs', 'fournisseurs.id', 'entries.fournisseur_id')
        ->join('unities', 'unities.id', 'products.unity_id')
        ->select(
            'products.id',
            'familles.name as famille',
            'products.name as product',
            'unities.name as unity',
            'familles.inventaire',
            'entries.date_peremption',
            'entries.date_reception',
            'fournisseurs.name as fournisseur',
            'entries.lot_fournisseur',
            'stocks.prix_unitaire as prix',
            DB::raw('sum(stocks.qte_stock) as qte'),
            DB::raw('sum(stocks.qte_stock * stocks.prix_unitaire) as valeur'))
        ->where('products.id', $id)
        ->groupBy('products.id','entries.date_peremption','entries.lot_fournisseur', 'entries.date_reception','fournisseurs.name', 'familles.name','stocks.prix_unitaire', 'familles.inventaire', 'products.name', 'unities.name')
        ->get();

        return $stocks;
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

    public function stocksByProductExperationDate($id) {
        $this->stockRepository->findByProductExperationDate($id);
    }

    public function stocksByProductReceptionDate($id) {
        $this->stockRepository->findByProductReceptionDate($id);
    }
}
