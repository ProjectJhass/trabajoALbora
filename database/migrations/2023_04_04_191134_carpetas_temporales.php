<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CarpetasTemporales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos_temporales', function (Blueprint $table) {
            $table->bigIncrements('id_documento');
            $table->text('nombre_doc');
            $table->text('documento');
            $table->string('tipo');
            $table->text('url');
            $table->date('fecha_cargue');
            $table->date('fecha_eliminacion');
            $table->string('dpto');
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
        Schema::dropIfExists('documentos_temporales');
    }
}
