<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remito extends Model
{
    use HasFactory;

    protected $fillable = [
        'numberRemito',
        'nameClient',
        'address',
        'cuit',
        'users_id',
        'estado'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
