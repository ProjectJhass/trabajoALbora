<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreteTemasCapacitacionTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('app_nexus')->create('temas_capacitacion', function (Blueprint $table) {
            $table->id('id_tema');
            $table->string('nombre_tema');
            $table->string('objetivo_tema');
            $table->string('documento_tema');
            $table->string('url_tema');
            $table->string('estado');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temas_capacitacion');
    }
};
