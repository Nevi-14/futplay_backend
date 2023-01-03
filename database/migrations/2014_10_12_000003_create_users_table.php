<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('Cod_Usuario');
            $table->foreignId('Cod_Role')->references('Cod_Role')->on('Roles')->onDelete('cascade');
            $table->foreignId('Cod_Posicion')->references('Cod_Posicion')->on('Posiciones')->onDelete('cascade');
            $table->foreignId('Cod_Provincia')->references('Cod_Provincia')->on('Provincias')->onDelete('cascade');
            $table->foreignId('Cod_Canton')->references('Cod_Canton')->on('Cantones')->onDelete('cascade');
            $table->foreignId('Cod_Distrito')->references('Cod_Distrito')->on('Distritos')->onDelete('cascade');
            $table->boolean('Modo_Customizado')->nullable();
            $table->boolean('Avatar')->nullable();
            $table->string('Foto')->nullable();
            $table->string('Nombre');
            $table->string('Primer_Apellido');
            $table->string('Segundo_Apellido')->nullable();;
            $table->date('Fecha_Nacimiento');
            $table->string('Telefono')->unique();
            $table->string('Correo')->unique();
            $table->string('Contrasena');
            $table->integer('intentos')->nullable();;
            $table->double('Peso')->nullable();
            $table->double('Estatura')->nullable();
            $table->string('Apodo')->nullable();
            $table->integer('Partidos_Jugados')->nullable();
            $table->integer('Partidos_Jugador_Futplay')->nullable();
            $table->integer('Partidos_Jugador_Del_Partido')->nullable();
            $table->boolean('Estado')->default(true);
            $table->string('Descripcion_Estado')->nullable();
            $table->boolean('Compartir_Datos')->default(true);
            $table->boolean('Extranjero')->nullable();;
            $table->string('Pais')->nullable();
            $table->string('Cod_Pais')->nullable();
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
        Schema::dropIfExists('users');
    }
}
