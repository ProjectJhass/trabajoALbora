<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BitacoraPuntosComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacora_coment_seg_p', function(Blueprint $table){
            $table->bigIncrements('id_seg_punto');
            $table->text('seg_punto');
            $table->text('responsable');
            $table->bigInteger('id_punto_solicitud');
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
        Schema::dropIfExists('bitacora_coment_seg_p');
    }
}
