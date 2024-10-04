<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

 class CreateEmpresaTable extends Migration
{

    public function up()
    {
        Schema::create('Empresa', function(Blueprint $table){
            $table->id('id_empresa');
            $table->string('nombre_empresa');
            $table->text('descripcion_empresa');
            $table->timestamps();
        }   
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('Empresa');
    }
};
