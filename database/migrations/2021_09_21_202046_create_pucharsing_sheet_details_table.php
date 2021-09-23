<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePucharsingSheetDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pucharsing_sheet_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pucharsing_sheet_id');
            $table->unsignedBigInteger('material_id');
            $table->integer('amount');
            $table->integer('presentation');
            $table->unsignedBigInteger('provider_id');

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
        Schema::dropIfExists('pucharsing_sheet_details');
    }
}
