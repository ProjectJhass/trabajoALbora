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
        Schema::connection('app_nexus')->create('modulos_capacitacion', function (Blueprint $table) {
            $table->id('id_modulo');
            $table->text('nombre_modulo');
            $table->string('descripcion_modulo');
            $table->text('name_image');
            $table->string('estado');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulos_capacitacion');
    }
};
