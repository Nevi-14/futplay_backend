<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CanchasGeoLocalizacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canchas_geolocalizacion', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->foreignId('Cod_cancha')->references('Cod_cancha')->on('Canchas')->onDelete('cascade');
            $table->string('Codigo_Pais')->nullable();
            $table->string('Pais')->nullable();
            $table->string('Codigo_Estado')->nullable();
            $table->string('Estado')->nullable();
            $table->string('Codigo_Ciudad')->nullable();
            $table->string('Ciudad')->nullable();
            $table->string('Codigo_Postal')->nullable();
            $table->string('Direccion')->nullable();
            $table->integer('Latitud')->nullable();
            $table->integer('Longitud')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('canchas_geolocalizacion');
    }
}
