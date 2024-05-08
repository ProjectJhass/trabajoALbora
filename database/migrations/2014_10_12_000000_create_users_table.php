<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->text('nombre');
            $table->text('email');
            $table->integer('permisos');
            $table->integer('dpto_user');
            $table->integer('permiso_dpto');
            $table->string('sucursal', 20);
            $table->string('cargo',45);
            $table->string('usuario',65);
            $table->text('password');
            $table->integer('zona');
            $table->integer('ingreso_personal');
            $table->integer('calendario');
            $table->integer('estado');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
