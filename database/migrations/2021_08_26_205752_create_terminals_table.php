<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerminalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id');
            $table->float('size', 6, 2);
            $table->float('minimum_section', 6, 2);
            $table->float('maximum_section',6, 2);  
            $table->enum('material', ['Latón', 'Estañado']);
            $table->enum('type', ['Porta macho', 'Porta hembra']);
       
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
        Schema::dropIfExists('terminals');
    }
}
