<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receiver extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'service_id',
        'statut'
    ];
    public function sorties()
    {
        return $this->hasMany(Sortie::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
