<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id');
            $table->string('name', 100);
            $table->string('address', 100);
            $table->string('phone', 100)->nullable();
            $table->string('email', 100);
            $table->string('contact_name', 100)->nullable();
            $table->string('point_contact', 100)->nullable();
            $table->string('site_url', 100)->nullable();
            $table->integer('status');
            
          //  $table->foreign('material_id')->references('id')->on('materials');
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
        Schema::dropIfExists('providers');
    }
}
