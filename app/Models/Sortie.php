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
        return $this->belongsTo(Unity::class);
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
    public function receiver()
    {
        return $this->belongsTo(Receiver::class);
    }
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function exercice()
    {
        return $this->belongsTo(Exercice::class);
    }
}
