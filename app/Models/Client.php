<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Client extends Model
{
    use HasRoles, HasFactory;

    

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
