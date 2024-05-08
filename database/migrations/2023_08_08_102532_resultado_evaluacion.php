<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ResultadoEvaluacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultado_evaluacion', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('id_departamento');
            $table->bigInteger('id_pregunta');
            $table->bigInteger('id_usuario');
            $table->float('porcentaje_pregunta');
            $table->date('fecha');
            $table->bigInteger('usuario_evaluado');
            $table->bigInteger('id_centro_operacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resultado_evaluacion');
    }
}
