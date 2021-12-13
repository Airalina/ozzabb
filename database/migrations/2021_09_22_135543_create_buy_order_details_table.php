<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id');
            $table->integer('presentation');
            $table->unsignedBigInteger('buy_order_id');
            $table->integer('amount');
            $table->float('presentation_price');
            $table->float('total_price');
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
        Schema::dropIfExists('buy_order_details');
    }
}
