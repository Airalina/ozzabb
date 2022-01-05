<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFamilyToMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /* Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('family');
            $table->enum('family', ['Conectores', 'Terminales', 'Cables', 'Sellos', 'Tubos', 'Accesorios', 'Clips']);
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
