<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsNullablesToConnectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('connectors', function (Blueprint $table) {
            $table->integer('number_of_ways')->nullable()->change();
            $table->string('type', 100)->nullable()->change();
            $table->integer('watertight')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('connectors', function (Blueprint $table) {
            //
        });
    }
}
