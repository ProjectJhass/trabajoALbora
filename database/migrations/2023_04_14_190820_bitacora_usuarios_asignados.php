<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BitacoraUsuariosAsignados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacora_usuarios', function (Blueprint $table) {
            $table->bigIncrements('id_asignacion');
            $table->bigInteger('id_solicitud');
            $table->bigInteger('id_usuario');
            $table->string('procentaje_seguimiento', 45);
            $table->string('estado');
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
        Schema::dropIfExists('bitacora_usuarios');
    }
}
