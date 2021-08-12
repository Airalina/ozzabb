<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientorders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('customer_name');
            $table->dateTime('date');
            $table->date('deadline');
            $table->dateTime('start_date')->nullable();
            $table->integer('buys')->nullable();
            $table->unsignedBigInteger('order_state')->nullable();
            $table->unsignedBigInteger('order_job')->nullable();
            $table->float('usd_price')->nullable();
            $table->float('arp_price')->nullable();
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
        Schema::dropIfExists('clientorders');
    }
}
