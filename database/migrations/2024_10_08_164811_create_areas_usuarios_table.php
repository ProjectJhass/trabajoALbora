<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

 class  CreateAreaUsuariosTable  extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('app_nexus')->create('area_usuarios', function (Blueprint $table) {
            $table->bigIncrements('id_area_usuarios');
            $table->unsignedBigInteger('id');       // ID del usuario
            $table->unsignedBigInteger('id_dpto');  // ID del departamento

            // Definir las claves foráneas
            $table->foreign('id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_dpto')->references('id_dpto')->on('areas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas_usuarios');
    }
};
