<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->insert([
            'id'=>1,
            'name' => 'Emiliano',
            'nombre_y_apellido' => 'Emiliano Muñoz',
            'domicilio' => 'Algun Lugar',
            'telefono' => '2644444444',
            'email' => 'emiliano@codigitar.com',
            'activo' => 1,
            'dni' => '15678987',
            'password' => \Hash::make('12345678'),
        ]);

        
    
    }
}
