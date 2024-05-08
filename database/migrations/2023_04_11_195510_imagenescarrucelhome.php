<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Imagenescarrucelhome extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imagenes_carrucel', function (Blueprint $table) {
            $table->bigIncrements('id_carrucel');
            $table->text('nombre_imagen');
            $table->text('url_imagen');
            $table->string('tipo', 45);
            $table->integer('orden');
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
        Schema::dropIfExists('imagenes_carrucel');
    }
}
