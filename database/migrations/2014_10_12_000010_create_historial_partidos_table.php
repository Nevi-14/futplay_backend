<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialPartidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_partidos', function (Blueprint $table) {
            $table->bigIncrements('Cod_Partido');
            $table->foreignId('Cod_Reservacion')->references('Cod_Reservacion')->on('Reservaciones')->onDelete('cascade');
            $table->foreignId('Cod_Equipo')->references('Cod_Equipo')->on('Equipos')->onDelete('cascade');
            $table->boolean('Evaluacion')->nullable();
            $table->boolean('Verificacion_QR')->nullable();
            $table->double('Goles_Retador')->nullable();
            $table->double('Goles_Rival')->nullable();
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
        Schema::dropIfExists('historial_partidos');
    }
}
