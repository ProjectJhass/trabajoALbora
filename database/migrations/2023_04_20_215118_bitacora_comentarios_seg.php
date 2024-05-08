<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BitacoraComentariosSeg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacora_coments_seg', function(Blueprint $table){
            $table->bigIncrements('id_seguimiento');
            $table->text('seguimiento');
            $table->text('responsable');
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
        Schema::dropIfExists('bitacora_coments_seg');
    }
}
