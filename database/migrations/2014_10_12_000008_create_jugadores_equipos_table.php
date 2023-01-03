<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJugadoresEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jugadores_equipos', function (Blueprint $table) {
            $table->bigIncrements('Cod_Jugador');
            $table->foreignId('Cod_Usuario')->references('Cod_Usuario')->on('Usuarios')->onDelete('cascade');
            $table->foreignId('Cod_Equipo')->references('Cod_Equipo')->on('Equipos')->onDelete('cascade');
            $table->boolean('Favorito')->nullable();
            $table->boolean('Administrador')->default();
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
        Schema::dropIfExists('jugadores_equipos');
    }
}
