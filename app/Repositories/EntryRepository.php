<?php


namespace App\Repositories;

use App\Models\Entry;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class EntryRepository 
{

 public function findByProduct($id){

    // $product = Product::find($id);
    // return $product->entries;

    return Entry::where('product_id',$id)->get();
    return DB::table('entries')->where('product_id')->get();
 }

 public function findByFournisseur($id){
     
    return Entry::where('fournisseur_id',$id)->get();
}


}