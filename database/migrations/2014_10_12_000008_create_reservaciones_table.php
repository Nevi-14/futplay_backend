<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservaciones', function (Blueprint $table) {
            $table->bigIncrements('Cod_Reservacion');
            $table->foreignId('Cod_Usuario')->references('Cod_Usuario')->on('Usuarios')->onDelete('cascade');
            $table->foreignId('Cod_Cancha')->references('Cod_Cancha')->on('Canchas')->onDelete('cascade');
            $table->foreignId('Cod_Estado')->references('Cod_Estado')->on('Estados')->onDelete('cascade');
            $table->boolean('Reservacion_Externa')->nullable();
            $table->string('Titulo')->nullable();
            $table->date('Fecha');
            $table->datetime('Hora_Inicio')->nullable();
            $table->datetime('Hora_Fin')->nullable();
            $table->boolean('Dia_Completo')->nullable();
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
        Schema::dropIfExists('reservaciones');
    }
}
