<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemsToDepositInstallations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposit_installations', function (Blueprint $table) {
            $table->string('name_receive')->nullable();
            $table->string('name_entry')->nullable();
            $table->time('hour')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deposit_installations', function (Blueprint $table) {
            //
        });
    }
}
