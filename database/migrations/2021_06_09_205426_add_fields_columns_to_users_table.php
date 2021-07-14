<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
           $table->string('nombre_y_apellido')->after("name")->nullable();
           $table->string('domicilio')->after("email")->nullable();
           $table->string('dni')->after("domicilio")->nullable();
           $table->string('telefono')->after("nombre_y_apellido")->nullable();
           $table->boolean('activo')->after('dni')->nullable();
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
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
