<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable = [
            'qte','prix_unitaire','taux_change','date_peremption','date_reception','lot_fournisseur',
            'bon_commande','product_id','currency_id','user_id','fournisseur_id','unity_id','cofe'
        ];
  

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }
    public function product()
    {
        return $this->belongsTo(product::class);
    }

    // public function stock()
    // {
    //     return $this->belongsTo(Entree::class);
    // }
    public function exercice()
    {
        return $this->belongsTo(Exercice::class);
    }

    public function unity()
    {
        return $this->belongsTo(Unity::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
