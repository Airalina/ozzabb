<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFildColumnsToPucharsingSheetDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pucharsing_sheet_details', function (Blueprint $table) {
            $table->float('usd_price')->after("presentation");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pucharsing_sheet_details', function (Blueprint $table) {
            //
        });
    }
}
