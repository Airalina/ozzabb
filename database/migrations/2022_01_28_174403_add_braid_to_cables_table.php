<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBraidToCablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cables', function (Blueprint $table) {
            $table->enum('braid_configuration', ['16 x 30 mm', '34 x 20 mm', '7 x 0.25 mm', '16 x 0.20 mm']);
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
