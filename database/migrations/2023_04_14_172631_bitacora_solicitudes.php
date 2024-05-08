<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BitacoraSolicitudes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacora_solicitudes', function(Blueprint $table){
            $table->bigIncrements('id_solicitud');
            $table->string('tipo_solicitud',45);
            $table->text('nombre_solicitud');
            $table->text('descripcion');
            $table->date('fecha_creacion');
            $table->date('fecha_posible_entrega')->nullable();
            $table->date('fecha_terminado')->nullable();
            $table->string('estado',45);
            $table->string('porcentaje',45);
            $table->string('color',45);
            $table->bigInteger('id_solicitante');
            $table->text('nombre_solicitante');
            $table->string('prioridad',45)->nullable();
            $table->string('categoria',20);
            $table->string('organizacion',20);
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
        Schema::dropIfExists('bitacora_solicitudes');
    }
}
