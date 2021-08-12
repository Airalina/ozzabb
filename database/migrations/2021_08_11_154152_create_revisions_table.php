<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revisions', function (Blueprint $table) {
            $table->unsignedBigInteger('installation_id');
            $table->unsignedBigInteger('number_version');
            $table->date('create_date');
            $table->string('reason', 300);
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
        Schema::dropIfExists('revisions');
    }
}
