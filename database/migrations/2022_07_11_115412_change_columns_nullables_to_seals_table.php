<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsNullablesToSealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seals', function (Blueprint $table) {
            $table->float('minimum_diameter', 6, 2)->nullable()->change();
            $table->float('maximum_diameter', 6, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seals', function (Blueprint $table) {
            //
        });
    }
}
