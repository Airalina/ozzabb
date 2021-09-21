<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialEntryOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_entry_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entry_order_id');
            $table->integer('material_code');
            $table->string('material_description');
            $table->unsignedBigInteger('warehouse_id');
            $table->string('set')->nullable();
            $table->integer('amount_requested')->nullable();
            $table->integer('presentation');
            $table->integer('amount_follow')->nullable();
            $table->integer('amount_received');
            $table->integer('amount_undelivered')->nullable();
            $table->integer('difference')->nullable();
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
        Schema::dropIfExists('material_entry_order_details');
    }
}
