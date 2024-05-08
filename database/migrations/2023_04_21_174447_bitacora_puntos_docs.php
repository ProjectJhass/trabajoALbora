<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BitacoraPuntosDocs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacora_docs_puntos', function(Blueprint $table){
            $table->bigIncrements('id_docs_p');
            $table->text('nom_doc_p');
            $table->text('doc_punto');
            $table->text('url_doc_p');
            $table->string('tipo_doc_p', 45);
            $table->string('tama_doc_p', 45);
            $table->bigInteger('id_comment_seg_p');
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
        //
    }
}
