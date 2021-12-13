<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DomicileDeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('domicile_deliveries')->insert([
            
            'street' => 'R.N. N°40',
            'number' => 'KM 3500',
            'location' => 'Albardon',
            'province' => 'San Juan',
            'country' => 'Argentina',
            'postcode' => '5419',
            'client_id' => 1,
        ]);
    }
}
