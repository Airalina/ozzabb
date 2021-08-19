<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevisiondetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revisiondetails', function (Blueprint $table) {
            $table->unsignedBigInteger('installation_id');
            $table->unsignedBigInteger('number_version');
            $table->unsignedBigInteger('material_id');
            $table->unsignedBigInteger('amount');
            $table->timestamps();
            $table->softDeletes();
            $table->primary(['installation_id','number_version']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('revisiondetails');
    }
}
