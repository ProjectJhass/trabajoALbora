<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuloTemas extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('app_nexus')->create('modulos_temas', function (Blueprint $table) {
            $table->id('id_modulos_temas');
            $table->unsignedBigInteger('id_modulo');
            $table->unsignedBigInteger('id_tema');

            $table->foreign('id_modulo')->references('id_modulo')->on('modulos_capacitacion')->onDelete('cascade');
            $table->foreign('id_tema')->references('id_tema')->on('temas_capacitacion')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulos_temas');
    }
};
