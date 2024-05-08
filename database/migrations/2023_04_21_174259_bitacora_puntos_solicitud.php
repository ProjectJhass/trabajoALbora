<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BitacoraPuntosSolicitud extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacora_puntos_proyecto', function(Blueprint $table){
            $table->bigIncrements('id_punto');
            $table->text('titulo_punto');
            $table->text('descripcion_p');
            $table->string('prioridad_p',45);
            $table->date('fecha_terminado_p')->nullable();
            $table->string('estado_p',45);
            $table->string('porcentaje_p',45);
            $table->string('color_p',45);
            $table->bigInteger('id_solicitud');
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
        Schema::dropIfExists('bitacora_puntos_proyecto');
    }
}
