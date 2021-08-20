<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('customers')->insert([
            
            'name' => 'Andina SRL',
            'phone' => '2647568993',
            'email' => 'contacto@andina.com',
            'domicile_admin' => 'Av. Rioja 55(N)',
            'contact' =>'Raul Rios',
            'post_contact' => 'Encargado de compras',
            'estado' => 0,
        ]);
    }
}
