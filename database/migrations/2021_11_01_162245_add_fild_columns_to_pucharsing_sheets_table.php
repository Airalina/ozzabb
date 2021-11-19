<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFildColumnsToPucharsingSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pucharsing_sheets', function (Blueprint $table) {
            $table->float('usd_subtotal_price')->after("work_order_id");
            $table->float('iva')->after("usd_subtotal_price");
            $table->float('usd_total_price')->after("iva");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pucharsing_sheets', function (Blueprint $table) {
            //
        });
    }
}
