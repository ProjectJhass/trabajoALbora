<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargoUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('app_nexus')->create('cargo_usuarios', function (Blueprint $table) {
            $table->id('id_cargo_usuarios');
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('id_cargo');

            $table->foreign('id_cargo')->references('id_cargo')->on('cargos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargo_usuarios');
    }
};
