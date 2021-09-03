<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialEntryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_entry_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entry_order_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('buy_order_id');
            $table->string('follow_number');
            $table->date('date');
            $table->time('hour');
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
        Schema::dropIfExists('material_entry_orders');
    }
}
