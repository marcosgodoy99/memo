<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;


    protected $fillable = [
        'username',
        'address',
        'cuit',
        'phone',
        'users_id'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
