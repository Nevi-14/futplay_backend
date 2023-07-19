<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleReservacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_reservaciones', function (Blueprint $table) {
            $table->bigIncrements('Cod_Detalle');
            $table->foreignId('Cod_Reservacion')->references('Cod_Reservacion')->on('Reservaciones')->onDelete('cascade');
            $table->foreignId('Cod_Moneda')->references('ID')->on('Monedas')->onDelete('cascade');
            $table->foreignId('Cod_Estado')->references('Cod_Estado')->on('Estados')->onDelete('cascade');
            $table->foreignId('Cod_Retador')->references('Cod_Equipo')->on('Equipos')->onDelete('cascade');
            $table->foreignId('Cod_Rival')->references('Cod_Equipo')->on('Equipos')->onDelete('cascade');
            $table->boolean('Confirmacion_Rival')->nullable()->default(null);
            $table->boolean('Luz')->nullable();
            $table->double('Monto_Luz')->nullable();
            $table->double('Total_Horas')->nullable();
            $table->double('Precio_Hora')->nullable();           
            $table->string('Cod_Descuento')->nullable()->default(0);
            $table->double('Porcentaje_Descuento')->nullable()->default(0);
            $table->double('Monto_Descuento')->nullable()->default(0);
            $table->double('Porcentaje_Impuesto')->nullable()->default(0);
            $table->double('Monto_Impuesto')->nullable()->default(0);
            $table->double('Porcentaje_FP')->nullable();
            $table->double('Monto_FP')->nullable();
            $table->double('Monto_FP_Equipo')->nullable();
            $table->double('Monto_Equipo')->nullable();;
            $table->double('Monto_Sub_Total')->nullable();
            $table->double('Monto_Total')->nullable();
            $table->double('Pendiente')->nullable();
            $table->string('Notas_Estado')->nullable();
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
        Schema::dropIfExists('detalle_reservaciones');
    }
}
