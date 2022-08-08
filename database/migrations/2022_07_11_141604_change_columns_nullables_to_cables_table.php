<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsNullablesToCablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cables', function (Blueprint $table) {
            $table->float('section', 6, 2)->nullable()->change();
            $table->string('base_color')->nullable()->change();
            $table->float('operating_temperature', 6, 2)->nullable()->change();
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
