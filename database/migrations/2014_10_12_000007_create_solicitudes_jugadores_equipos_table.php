<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesJugadoresEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes_jugadores_equipos', function (Blueprint $table) {
            $table->bigIncrements('Cod_Solicitud');
            $table->foreignId('Cod_Usuario')->references('Cod_Usuario')->on('Usuarios')->onDelete('cascade');
            $table->foreignId('Cod_Equipo')->references('Cod_Equipo')->on('Equipos')->onDelete('cascade');
            $table->boolean('Confirmacion_Usuario')->nullable();
            $table->boolean('Confirmacion_Equipo')->nullable();
            $table->boolean('Estado')->default(true);
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
        Schema::dropIfExists('solicitudes_jugadores_equipos');
    }
}
