<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'permission',
    ];

    /**
     * Asigna un permiso al rol.
     *
     * @param string $nombrePermiso
     * @return void
     */
    

    public function asignarPermiso($nombrePermiso)
    {
        $permiso = Permission::where('permission', $nombrePermiso)->first();
        if ($permiso) {
            $this->roles()->attach($permiso); // Cambiado de $this->permission() a $this->roles()
        }
    }

    public function roles(){
        return $this->belongsTo(Role::class, 'rols_id', 'id');
    }
}
