<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory,SoftDeletes;
    
    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }
    // public function sortie()
    // {
    //     return $this->hasOne(Sortie::class);
    // }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // public function inventories()
    // {
    //     return $this->belongsTo(Inventory::class);
    // }
}
