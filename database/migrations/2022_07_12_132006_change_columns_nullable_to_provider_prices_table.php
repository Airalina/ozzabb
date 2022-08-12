<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsNullableToProviderPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provider_prices', function (Blueprint $table) {
            $table->float('unit',8,2)->nullable()->change();
            $table->string('presentation',50)->nullable()->change();
            $table->float('usd_price',8,2)->nullable()->change();
            $table->float('ars_price',8,2)->nullable()->change();
            $table->string('provider_code')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provider_prices', function (Blueprint $table) {
            //
        });
    }
}
