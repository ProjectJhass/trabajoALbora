<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IdeasFabrica extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("ideas_fabrica", function (Blueprint $table) {
            $table->bigIncrements('id_idea');
            $table->text('nombre_documento');
            $table->text('url_doc')->nullable();// se le añadio la propiedad nullable NUEVO
            $table->string('tipo_doc', 45);
            $table->date('fecha_cargue');
            $table->time('hora_cargue');
            $table->bigInteger('id_usuario');
            $table->timestamps();
            $table->text('link')->nullable(); // se hizo nuevo
            $table->string('categoria')->nullable(); // se hizo nuevo
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ideas_fabrica');
    }
}
