<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lineasRemito extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'quantity',
        'product',
        'idProduct',
        'remito_id',
        'price',
        'subtotal'
    ];
    public function remito(){
        return $this->belongsTo(Remito::class, 'remito_id', 'id');
    }
}
