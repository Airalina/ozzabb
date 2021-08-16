<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InstallationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('installations')->insert([
            
            'id' => '1',
            'code' => '23000',
            'date_admission' => '2021-08-16 22:00:00',
            'description' => 'Ramal Hilux',
            'usd_price' => '23.5',
        ]); 

        \DB::table('installations')->insert([
            
            'id' => '2',
            'code' => '78956',
            'date_admission' => '2020-01-24 09:00:00',
            'description' => 'Ramal Zanella',
            'usd_price' => '9.65',
        ]); 
    }
}
