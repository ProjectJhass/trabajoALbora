<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BitacoraDocumentsSeguimiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacora_docs_seg', function (Blueprint $table) {
            $table->bigIncrements('id_docs_seg');
            $table->text('nom_doc_seg');
            $table->text('doc_seg');
            $table->text('url_doc_seg');
            $table->string('tipo_doc_seg', 45);
            $table->string('tama_doc_seg', 45);
            $table->bigInteger('id_comentario_seg');
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
        Schema::dropIfExists('bitacora_docs_seg');
    }
}
