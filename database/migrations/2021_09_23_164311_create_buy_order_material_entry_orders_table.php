<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyOrderMaterialEntryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_order_material_entry_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buy_order_id');
            $table->unsignedBigInteger('entry_order_id');
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
        Schema::dropIfExists('buy_order_material_entry_orders');
    }
}
