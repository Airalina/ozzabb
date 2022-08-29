<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Provider;
use App\Models\Material;
use App\Models\Usage;
use App\Models\Line;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            RoleUserSeeder::class,
            CustomerSeeder::class,
            DomicileDeliverySeeder::class,
            PermissionSeeder::class,
            DollarSeeder::class,
       ]);
       Provider::factory(10)->create();
      # Material::factory(6)->create();
       Line::factory(4)->create();
       Usage::factory(6)->create();
    }
}
