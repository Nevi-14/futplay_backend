<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCantonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Cantones', function (Blueprint $table) {
            $table->bigIncrements('Cod_Canton');
            $table->foreignId('Cod_Provincia')->references('Cod_Provincia')->on('Provincias')->onDelete('cascade');
            $table->string('Canton');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Cantones');
    }
}
