<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsNullablesToTubesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tubes', function (Blueprint $table) {
            $table->float('diameter',6, 2)->nullable()->change();
            $table->float('wall_thickness',6, 2)->nullable()->change();
            $table->float('contracted_diameter',6, 2)->nullable()->change();
            $table->float('minimum_temperature',6, 2)->nullable()->change();
            $table->float('maximum_temperature',6, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tubes', function (Blueprint $table) {
            //
        });
    }
}
