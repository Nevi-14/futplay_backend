<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialPartidosEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_partidos_equipos', function (Blueprint $table) {
            $table->bigIncrements('Cod_Historial');
            $table->foreignId('Cod_Equipo')->references('Cod_Equipo')->on('Equipos')->onDelete('cascade');
            $table->string('Dureza')->nullable();
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
        Schema::dropIfExists('historial_partidos_equipos');
    }
}
