<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemsToTerminals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('terminals', function (Blueprint $table) {
            $table->float('size', 6, 2)->change();
            $table->float('minimum_section', 6, 2)->change();
            $table->float('maximum_section',6, 2)->change();  
            $table->enum('material', ['Latón', 'Estañado']);
            $table->enum('type', ['Porta macho', 'Porta hembra']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('terminals', function (Blueprint $table) {
            $table->dropColumn('material');
            $table->dropColumn('type');
        });
    }
}
