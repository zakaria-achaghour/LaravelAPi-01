<?php


namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository
 
{

 public function productsByFamilles($ids){

    $products = Product::whereIn('famille_id', $ids)->with(['fournisseurs','unity','famille','entries'])->get();
    return $products;
 }

 public function productsIDsByFamilles($ids){

   $productsIds = Product::select('id')->whereIn('famille_id', $ids)->with(['fournisseurs','unity','famille','entries'])->get();
   return $productsIds;
}




}