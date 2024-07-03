<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\Client;
use DB;

class DatabaseSeeder extends Seeder 
{
    /**
     * Crea los roles y permisos iniciales.
     */
    public function run(): void 
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        // Crear permisos
        Permission::create(['name' => 'admin',
                            'guard_name' => 'web']);

        $role = Role::create(['name' => 'admin',
                             'guard_name' => 'web']);
        
        $role->givePermissionTo(['admin']);
        
        /*$role2 = Role::create(['name' => 'comprador']);
        $role2->givePermissionTo('cliente');
       
        $role3 = Role::create(['name' => 'proeveedor']);
        $role3->givePermissionTo('proveedor');*/

        // Crear usuarios de demostración
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
        ]);

        $client = Client::factory(1)->create();

        $user->assignRole($role); // Asignar rol 'admin' al usuario
       
        $this->insertModelHasPermissions();
        $this->insertModelHasRoles();
        $this->insertRoleHasPermissions();
    }
    

    public function insertModelHasPermissions()
    {
        DB::table('model_has_permissions')->insert([
            'permission_id' => 1,
            'model_type' => 'App\Models\Users', // Ajusta el namespace del modelo si es necesario
            'model_id' => 1, // ID de usuario
        ]);
    }

    public function insertModelHasRoles()
    {
        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_type' => 'App\Models\Users', // Ajusta el namespace del modelo si es necesario
            'model_id' => 1, // ID de usuario
        ]);
    }

    public function insertRoleHasPermissions()
    {
        DB::table('role_has_permissions')->insert([
            'permission_id' => 1,
            'role_id' => 1,
        ]);
    }
}