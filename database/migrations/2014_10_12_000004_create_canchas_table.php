<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCanchasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canchas', function (Blueprint $table) {
            $table->bigIncrements('Cod_Cancha');
            $table->foreignId('Cod_Usuario')->references('Cod_Usuario')->on('Usuarios')->onDelete('cascade');
            $table->foreignId('Cod_Categoria')->references('Cod_Categoria')->on('Categorias')->onDelete('cascade');
            $table->foreignId('Cod_Provincia')->references('Cod_Provincia')->on('Provincias')->onDelete('cascade');
            $table->foreignId('Cod_Canton')->references('Cod_Canton')->on('Cantones')->onDelete('cascade');
            $table->foreignId('Cod_Distrito')->references('Cod_Distrito')->on('Distritos')->onDelete('cascade');
            $table->string('Foto')->nullable();
            $table->string('Nombre')->unique();
            $table->string('Numero_Cancha')->nullable();
            $table->string('Telefono')->nullable();;
            $table->double('Precio_Hora');
            $table->boolean('Luz')->nullable();
            $table->double('Precio_Luz')->nullable();
            $table->boolean('Techo')->nullable();
            $table->double('Latitud')->nullable();
            $table->double('Longitud')->nullable();
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
        Schema::dropIfExists('canchas');
    }
}
