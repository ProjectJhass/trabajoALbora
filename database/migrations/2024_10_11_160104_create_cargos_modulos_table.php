<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('app_nexus')->create('cargos_modulos', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_cargo');
            $table->unsignedBigInteger('id_modulo');

            $table->foreign('id_modulo')->references('id_modulo')->on('modulos_capacitacion')->onDelete('cascade');

            $table->foreign('id_cargo')->references('id_cargo')->on('cargos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargos_modulos');
    }
};
