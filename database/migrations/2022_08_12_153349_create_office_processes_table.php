<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_processes', function (Blueprint $table) {
            $table->id();
            $table->integer('office_id')->foreignId()->references('id')->on('officess')->onDelete('cascade');
            $table->integer('process_id')->foreignId()->references('id')->on('processes')->onDelete('cascade');
            $table->integer('doc1');
            $table->integer('doc2');
            $table->integer('doc3');
            $table->integer('doc4');
            $table->integer('month');
            $table->integer('year');
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
        Schema::dropIfExists('office_processes');
    }
}
