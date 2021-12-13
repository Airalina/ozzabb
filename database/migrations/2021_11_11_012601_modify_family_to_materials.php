<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyFamilyToMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Este código es comentado porque no se debería hacer este cambio mediante el comando change.
        //
      // Schema::table('materials', function (Blueprint $table) {
           // $table->enum('family', ['Conectores', 'Terminales', 'Cables', 'Sellos', 'Tubos', 'Accesorios', 'Clips'])->change();
      //  });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('family');
        });
    }
}
