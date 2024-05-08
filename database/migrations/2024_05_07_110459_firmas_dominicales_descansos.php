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
        Schema::create("firmas_descansos", function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('nombre')->nullable();
            $table->bigInteger('cedula')->nullable();
            $table->string("ciudad")->nullable();
            $table->string("depto")->nullable();
            $table->string("almacen")->nullable();
            $table->date('dominical_laborado')->nullable();
            $table->date('dia_compensatorio')->nullable();
            $table->text('nombre_firma')->nullable();
            $table->text('url_firma')->nullable();
            $table->string('tipo_firma', 10)->nullable();
            $table->string('ip_firma', 45)->nullable();
            $table->string("hash_firma", 25)->nullable();
            $table->text("observaciones")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("firmas_descansos");
    }
};
