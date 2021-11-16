<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fournisseur extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'sage',
        'name',
        'statut',
        'motif'
    ];

    public function products()
    {
      return $this->belongsToMany(Product::class);
    }
    public function entries()
    {
      return $this->belongsToMany(Entry::class);
    }
}
