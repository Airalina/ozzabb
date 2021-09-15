<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id');
            $table->float('size', 9, 1);
            $table->float('minimum_section', 9, 2);
            $table->float('maximum_section', 9, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cables');
    }
}
