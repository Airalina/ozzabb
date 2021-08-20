<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Provider;

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
       ]);
       Provider::factory(10)->create();
    }
}
