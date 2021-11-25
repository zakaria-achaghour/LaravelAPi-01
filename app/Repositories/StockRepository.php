<?php

namespace App\Repositories;
use Illuminate\Support\Facades\DB;

class StockRepository 
{

 public function findByProductExperationDate($id){

    return DB::table('stocks')
    ->join('entries', 'entries.id', 'stocks.entry_id')
    ->join('products', 'products.id', 'stocks.product_id')
    ->select('stocks.id as stock_id', 'products.id as product_id', 'product.famille_id', 'stocks.entry_id', 'entries.date_peremption', 'entries.date_reception','entries.date_peremption','stocks.entamer')
     ->where('stocks.product_id', $id)
            ->where('stocks.qte', '<>', 0)
            ->where('stocks.deleted_at', Null)
            ->where('entries.date_peremption', '<>',Null)
            ->orderBy('entries.date_peremption')
            ->get();
 }

 public function findByProductReceptionDate($id){
    return DB::table('stocks')
    ->join('entries', 'entries.id', 'stocks.entry_id')
    ->join('products', 'products.id', 'stocks.product_id')
    ->select('stocks.id as stock_id', 'products.id as product_id', 'product.famille_id', 'stocks.entry_id', 'entries.date_peremption', 'entries.date_reception','stocks.entamer')
    ->where('stocks.product_id', $id)
    ->where('stocks.qte', '<>', 0)
    ->where('stocks.deleted_at', Null)
    ->where('entries.date_peremption', Null)
    ->orderBy('entries.date_reception')
    ->get();
}


}