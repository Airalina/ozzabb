<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id');
            $table->float('minimum_diameter', 6, 2);
            $table->float('maximum_diameter', 6, 2);
            $table->string('type', 100)->nullable();
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
        Schema::dropIfExists('seals');
    }
}
