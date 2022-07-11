<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsNulToCablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cables', function (Blueprint $table) {
            DB::connection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
            DB::statement("ALTER TABLE `cables` MODIFY COLUMN  `braid_configuration` ENUM('16 x 30 mm', '34 x 20 mm', '7 x 0.25 mm', '16 x 0.20 mm');");
            DB::statement("ALTER TABLE `cables` MODIFY COLUMN  `norm` ENUM('Iram 247-5', 'Iram 247-3', 'IR','ID','Blindado','Multifilar');");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cables', function (Blueprint $table) {
            //
        });
    }
}
