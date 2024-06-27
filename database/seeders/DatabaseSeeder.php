<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Rol;
use App\Models\User;

class DatabaseSeeder extends Seeder 
{
    /**
     * Crea los roles y permisos iniciales.
     */
    public function run(): void 
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        // Crear permisos
        Permission::create(['name' => 'todo']);
        Permission::create(['name' => 'cliente']);
        Permission::create(['name' => 'proveedor']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(['todo','cliente','proveedor']);
        
        $role2 = Role::create(['name' => 'comprador']);
        $role2->givePermissionTo('cliente');
       
        $role3 = Role::create(['name' => 'proeveedor']);
        $role3->givePermissionTo('proveedor');

        // Crear usuarios de demostración
        $user = User::factory()->create([
            'name' => 'Jose Ramirez',
            'email' => 'admin@example.com',
        ]);

        //$rol3 = Rol::create(['rol' => 'admin']);
        //$rol3->asignarPermiso('all'); // Asignar permiso 'all' al rol 'admin'
        //$user->asignarRol($rol3); // Asignar rol 'admin' al usuario
    }
}