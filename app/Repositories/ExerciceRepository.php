<?php


namespace App\Repositories;

use App\Models\Exercice;
use Carbon\Carbon;

class ExerciceRepository 
{

    public function findId(){

        $year = Carbon::now()->format('Y');
        $exercice= Exercice::where('year',$year)->where('statut',true)->value('id');
        return $exercice;
     }
}