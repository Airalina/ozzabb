<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePucharsingSheetOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pucharsing_sheet_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pucharsing_sheet_id');
            $table->unsignedBigInteger('clientorder_id');
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
        Schema::dropIfExists('pucharsing_sheet_orders');
    }
}
