<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DollarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('dollars')->insert([
            'id' => 1,
            'arp_price' => 206,
        ]);
    }
}
