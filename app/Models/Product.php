<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'sage',
        'name',
        'min',
        'max',
        'famille',
        'unity',
        'lot_fournisseur',
        'date_peremption',
        'prix_moyen',
        'statut',
        'motif'
    ];

    public function unite()
    {
        return $this->belongsTo(Unite::class);
    }
    public function famille()
    {
        return $this->belongsTo(Famille::class);
    }

    public function fournisseurs()
    {
      return $this->belongsToMany(Fournisseur::class);
    }
}
