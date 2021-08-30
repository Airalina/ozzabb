<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->unsignedBigInteger('material_id');
            $table->unsignedBigInteger('provider_id');
            $table->float('unit',8,2);
            $table->string('presentation',50);
            $table->float('usd_price',8,2);
            $table->float('ars_price',8,2);
            $table->timestamps();
        //    $table->foreign("material_id")->refereces("id")->on("materials");
         //   $table->foreign("provider_id")->refereces("id")->on("providers");
         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_prices');
    }
}
