<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NumerosDeContactoAlbura extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('numeros_de_contacto', function (Blueprint $table) {
            $table->bigIncrements('id_numero');
            $table->text('nombre_propietario');
            $table->string('numero_celular', 45);
            $table->string('co', 45);
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
        Schema::dropIfExists('numeros_de_contacto');
    }
}
