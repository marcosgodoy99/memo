<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'stock',
        'price',
        'description',
        'links',
    ];

    public function orders(){
        return $this->hasMany(Order::class, 'products_id', 'id');
    }

    public function categoria(){
        return $this->belongsTo(Categorias::class, 'categorias_id', 'id');
    }
}
