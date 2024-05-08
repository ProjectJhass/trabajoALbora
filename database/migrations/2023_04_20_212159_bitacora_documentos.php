<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BitacoraDocumentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacora_documentos', function(Blueprint $table){
            $table->bigIncrements('id_documento');
            $table->text('nombre_documento');
            $table->text('documento');
            $table->text('url_doc');
            $table->string('tipo_doc',45);
            $table->string('tama_doc',45);
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
        Schema::dropIfExists('bitacora_documentos');
    }
}
