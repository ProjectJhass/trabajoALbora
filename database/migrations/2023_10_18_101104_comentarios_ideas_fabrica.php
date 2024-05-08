<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ComentariosIdeasFabrica extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("comentarios_ideas", function (Blueprint $table) {
            $table->bigIncrements('id_comentario');
            $table->text('comentarios');
            $table->date('fecha_comentario');
            $table->time("hora_comentario");
            $table->bigInteger('id_ideas');
            $table->bigInteger('id_usuario');
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
        Schema::dropIfExists('comentarios_ideas');
    }
}
