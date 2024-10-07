<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

 class CreateAreasTable extends Migration
{

    protected $connection = 'app_nexus';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id('id_dpto');
            $table->unsignedBigInteger('id_empresa');
            $table->string(column: 'nombre_dpto');
            $table->string(column: 'name_image');
            $table->text('descripcion_dpto')->nullable();
            $table->timestamps();

                        // Si deseas establecer una relación con la tabla de empresas, descomenta la siguiente línea:
            $table->foreign('id_empresa')->references('id_empresa')->on('Empresa');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
