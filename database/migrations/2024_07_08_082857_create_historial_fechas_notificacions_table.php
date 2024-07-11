<?php

use App\Models\apps\servicios_tecnicos\servicios\ModelEtapasServicios;
use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
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
        Schema::create('historial_fechas_notificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ModelNuevaSolicitud::class, 'id_st');
            $table->foreignIdFor(ModelEtapasServicios::class, 'id_etapa');
            $table->date('fecha_inicial');
            $table->bigInteger('transcurrido');
            $table->bigInteger('retraso');
            $table->date('fecha_envio');
            $table->string('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_fechas_notificaciones');
    }
};
