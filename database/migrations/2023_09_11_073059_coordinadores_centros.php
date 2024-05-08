<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CoordinadoresCentros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordinadores_cententros', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('id_cedula');
            $table->bigInteger('id_centro');
            $table->bigInteger('id_evaluador');
            $table->bigInteger('estado');
            $table->date('fecha_deshabilitado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coordinadores_cententros');
    }
}
