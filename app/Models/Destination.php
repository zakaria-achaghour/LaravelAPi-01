<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Destination extends Model
{
    use HasFactory, SoftDeletes;
  
    protected $fillable = [
        'name',
        'code',
        'statut'
    ];
    public function sorties()
    {
        return $this->hasMany(Sortie::class);
    }
}
