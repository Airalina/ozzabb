<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomicileDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domicile_deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('street', 200);
            $table->string('number',200);
            $table->string('location',200);
            $table->string('province',200);
            $table->string('country',200);
            $table->string('postcode',200);
            $table->unsignedBigInteger('client_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domicile_deliveries');
    }
}
