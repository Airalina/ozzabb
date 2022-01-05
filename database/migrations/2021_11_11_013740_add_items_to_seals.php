<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemsToSeals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /* Schema::table('seals', function (Blueprint $table) {
            $table->float('minimum_diameter', 6, 2);
            $table->float('maximum_diameter', 6, 2);
            $table->string('type', 100)->nullable();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('seals', function (Blueprint $table) {
            $table->dropColumn('minimum_diameter');
            $table->dropColumn('maximum_diameter');
            $table->dropColumn('type');
        });*/
    }
}
