<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MaterialReleaseOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_release_orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->integer('status')->nullable();
            $table->dateTime('date')->nullable();
            $table->time('hour')->nullable();
            $table->string('responsible')->nullable();
            $table->integer('products')->nullable();
            $table->integer('units')->nullable();
            $table->string('destination');
            
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
        //
    }
}
