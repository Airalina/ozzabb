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
            $table->string('code', 100);
            $table->string('name', 100);
            $table->enum('family', ['Conectores', 'Terminales', 'Cables', 'Sellos', 'Tubos', 'Accesorios', 'Clips']);
            $table->string('color', 50);
            $table->text('description')->nullable();
            $table->enum('line', ['Superseal', 'Mini', 'Fit', 'Bulldog', 'Ecoseal', 'Eco']);
            $table->enum('usage', ['Motos', 'GNC', 'Electro']);
            $table->integer('replace_id')->nullable();
            $table->integer('stock_min');
            $table->integer('stock_max')->nullable();
            $table->integer('stock');
            $table->string('image', 1000)->nullable();
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
