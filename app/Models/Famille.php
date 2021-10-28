<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Famille extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name',
        'service_id',
        'lot_fournisseur',
        'date_peremption'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
