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
            $table->float('section', 6, 2);
            $table->string('base_color');
            $table->string('line_color')->nullable();
            $table->enum('braid_configuration', ['16 x 30mm', '34 x 20mm']);
            $table->enum('norm', ['Iram 247-5', 'Iram 247-3', 'IR','ID','Blindado','Multifilar']);
            $table->integer('number_of_unipolar')->nullable();
            $table->string('mesh_type')->nullable();
            $table->float('operating_temperature', 6, 2);
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
