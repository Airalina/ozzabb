<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('permissions')->insert([
            
            'name' => 'Administracion de Usuarios',
            'see' => 1,
            'create' => 1,
            'update' => 1,
            'delete' =>1,
            'role_id' => 1,
        ]);

        \DB::table('permissions')->insert([
            
            'name' => 'Administracion de Roles',
            'see' => 1,
            'create' => 1,
            'update' => 1,
            'delete' =>1,
            'role_id' => 1,
        ]);

        \DB::table('permissions')->insert([
            
            'name' => 'Administracion de Clientes',
            'see' => 1,
            'create' => 1,
            'update' => 1,
            'delete' =>1,
            'role_id' => 1,
        ]);

        \DB::table('permissions')->insert([
            
            'name' => 'Administracion de Pedidos De Clientes',
            'see' => 1,
            'create' => 1,
            'update' => 1,
            'delete' =>1,
            'role_id' => 1,
        ]);
        
        \DB::table('permissions')->insert([
            
            'name' => 'Administracion de Instalaciones',
            'see' => 1,
            'create' => 1,
            'update' => 1,
            'delete' =>1,
            'role_id' => 1,
        ]);
    }
}
