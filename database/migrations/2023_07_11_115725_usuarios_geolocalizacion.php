<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsuariosGeoLocalizacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios_geolocalizacion', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->foreignId('Cod_Usuario')->references('Cod_Usuario')->on('Usuarios')->onDelete('cascade');
            $table->string('Codigo_Pais')->nullable();
            $table->string('Codigo_Estado')->nullable();
            $table->string('Codigo_Ciudad')->nullable();
            $table->string('Codigo_Postal')->nullable();
            $table->string('Direccion')->nullable();
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
        Schema::dropIfExists('usuarios_geolocalizacion');
    }
}
