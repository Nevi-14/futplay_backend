<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorarioCanchasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horario_canchas', function (Blueprint $table) {
            $table->bigIncrements('Cod_Horario');
            $table->foreignId('Cod_Cancha')->references('Cod_Cancha')->on('Canchas')->onDelete('cascade');
            $table->string('Cod_Dia');
            $table->integer('Hora_Inicio');
            $table->integer('Hora_Fin');
            $table->boolean('Estado');
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
        Schema::dropIfExists('horario_canchas');
    }
}
