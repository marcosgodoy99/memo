<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'products_id',
        'users_id',
        'quantity'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
    public function products(){
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }
}
