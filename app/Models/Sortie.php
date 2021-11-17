<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sortie extends Model
{
    use HasFactory, SoftDeletes;
    public function unity()
    {
        return $this->belongsTo(Unite::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function famille()
    {
        return $this->belongsTo(Famille::class);
    }
    // public function distinataire()
    // {
    //     return $this->belongsTo(distinataire::class);
    // }
    // public function distination()
    // {
    //     return $this->belongsTo(distination::class);
    // }

    public function exercice()
    {
        return $this->belongsTo(Exercice::class);
    }
}
