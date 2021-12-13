<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemsToDepositMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposit_materials', function (Blueprint $table) {
            $table->unsignedBigInteger("warehouse2_id")->nullable();
            $table->boolean('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deposit_materials', function (Blueprint $table) {
            //
        });
    }
}
