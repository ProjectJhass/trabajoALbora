<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EvaluacionPorcentajeTotal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('porcentaje_total_evaluacion', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('id_departamento');
            $table->bigInteger('id_usuario');
            $table->date('fecha');
            $table->float('porcentaje_total');
            $table->bigInteger('usuario_evaluado');
            $table->bigInteger('id_centro_operacione');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('porcentaje_total_evaluacion');
    }
}
