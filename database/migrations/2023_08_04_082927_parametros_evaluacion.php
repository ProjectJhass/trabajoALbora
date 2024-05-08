<?php

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ParametrosEvaluacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametros_evaluacion', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('id_departamento');
            $table->longText('parametros_calificar');
            $table->integer('porcentaje_parametro'); // Corrección aquí
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parametros_evaluacion');
    }
}
