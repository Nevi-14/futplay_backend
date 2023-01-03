<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistritosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Distritos', function (Blueprint $table) {
            $table->bigIncrements('Cod_Distrito');
            $table->foreignId('Cod_Canton')->references('Cod_Canton')->on('Cantones')->onDelete('cascade');
            $table->string('Distrito');
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
        Schema::dropIfExists('Distritos');
    }
}
