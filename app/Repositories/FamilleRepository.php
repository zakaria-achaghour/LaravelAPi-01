<?php


namespace App\Repositories;

use App\Models\Famille;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FamilleRepository
 
{

 public function famillesIdsByUser(){

    $familles = Auth::user()->familles;
    $famillesID = [];
    for ($i = 0; $i < count($familles); $i++) {    
        $famillesID[$i] = $familles[$i]->id;
    }
    return $famillesID;
 }




}