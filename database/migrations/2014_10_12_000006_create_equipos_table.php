<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->bigIncrements('Cod_Equipo');
            $table->foreignId('Cod_Usuario')->references('Cod_Usuario')->on('Usuarios')->onDelete('cascade');
            $table->foreignId('Cod_Provincia')->references('Cod_Provincia')->on('Provincias')->onDelete('cascade');
            $table->foreignId('Cod_Canton')->references('Cod_Canton')->on('Cantones')->onDelete('cascade');
            $table->foreignId('Cod_Distrito')->references('Cod_Distrito')->on('Distritos')->onDelete('cascade');
            $table->boolean('Avatar')->nullable();
            $table->string('Foto')->nullable();
            $table->string('Nombre')->unique();
            $table->string('Abreviacion')->unique()->default(0);
            $table->integer('Estrellas')->nullable()->default(1);
            $table->integer('Estrellas_Anteriores')->nullable()->default(0);
            $table->string('Dureza');
            $table->integer('Posicion_Actual')->nullable()->default(0);
            $table->integer('Puntaje_Actual')->nullable()->default(0);
            $table->integer('Partidos_Ganados')->nullable()->default(0);
            $table->integer('Partidos_Perdidos')->nullable()->default(0);
            $table->integer('Goles_Favor')->nullable()->default(0);
            $table->integer('Goles_Encontra')->nullable()->default(0);
            $table->double('Promedio_Altura_Jugadores')->nullable()->default(0);
            $table->double('Promedio_Peso_Jugadores')->nullable()->default(0);
            $table->boolean('Estado')->default(true);
            $table->string('Descripcion_Estado')->nullable();
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
        Schema::dropIfExists('equipos');
    }
}
