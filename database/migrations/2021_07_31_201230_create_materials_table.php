<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->string('code', 100);
            $table->string('name', 100);
            $table->enum('family', ['Conectores', 'Terminales', 'Cables', 'Sellos']);
            $table->string('color', 50);
            $table->text('description');
            $table->integer('line_id');
            $table->integer('usage_id');
            $table->string('replace', 50);
            $table->integer('stock_min');
            $table->integer('stock_max');
            $table->integer('stock');
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
        Schema::dropIfExists('materials');
    }
}
