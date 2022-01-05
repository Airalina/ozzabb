<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTubesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('tubes', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('material_id');
            $table->enum('type', ['Corrugado', 'Termocontraible', 'PVC']);
            $table->float('diameter',6, 2);
            $table->float('wall_thickness',6, 2);
            $table->float('contracted_diameter',6, 2);
            $table->float('minimum_temperature',6, 2);
            $table->float('maximum_temperature',6, 2);
            $table->timestamps();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tube');
    }
}
