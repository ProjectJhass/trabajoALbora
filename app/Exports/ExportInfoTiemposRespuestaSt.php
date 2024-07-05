<?php

namespace App\Exports;

use App\Models\apps\servicios_tecnicos\servicios\ModelHistorialSeguimiento;
use App\Models\apps\servicios_tecnicos\servicios\ModelEtapasServicios;
use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExportInfoTiemposRespuestaSt implements FromCollection, WithHeadings, WithTitle, WithColumnWidths
{
    private $fecha_i;
    private $fecha_f;
    private $fechaActual;
    private $fechaFinMesActual;
    public function __construct($fecha_i = null, $fecha_f = null)
    {
        $this->fechaActual = date('Y-m-01');
        $this->fechaFinMesActual = date('Y-m-t');
        $this->fecha_i = $fecha_i;
        $this->fecha_f = $fecha_f;
    }

    public function collection()
    {

        $query = ModelHistorialSeguimiento::select(
            'historial_seguimiento.id_st',
            DB::raw("MAX(servicios_tecnicos.cedula) AS cedula"),
            DB::raw("MAX(servicios_tecnicos.nombre) AS nombre"),
            DB::raw("MAX(servicios_tecnicos.created_at) AS fecha"),
            DB::raw("MAX(servicios_tecnicos.almacen) AS almacen"),
            DB::raw("MAX(CASE WHEN etapas_servicos.etapa = 'Creación' THEN CONCAT(IF(DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) = 0, 1, DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) - (SELECT  COUNT(*) FROM db_plataformas.fechasexcluidas fe WHERE fe.fecha BETWEEN historial_seguimiento.created_at and historial_seguimiento.updated_at)), ' dias') ELSE NULL END) AS Creación"),
            DB::raw("MAX(CASE WHEN etapas_servicos.etapa = 'Visita/Evidencias' THEN CONCAT(IF(DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) = 0, 1, DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) - (SELECT  COUNT(*) FROM db_plataformas.fechasexcluidas fe WHERE fe.fecha BETWEEN historial_seguimiento.created_at and historial_seguimiento.updated_at)), ' dias') ELSE NULL END) AS Visita_Evidencias"),
            DB::raw("MAX(CASE WHEN etapas_servicos.etapa = 'Valoracion' THEN CONCAT(IF(DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) = 0, 1, DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) - (SELECT  COUNT(*) FROM db_plataformas.fechasexcluidas fe WHERE fe.fecha BETWEEN historial_seguimiento.created_at and historial_seguimiento.updated_at)), ' dias') ELSE NULL END) AS Valoracion"),
            DB::raw("MAX(CASE WHEN etapas_servicos.etapa = 'Recogida' THEN CONCAT(IF(DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) = 0, 1, DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) - (SELECT  COUNT(*) FROM db_plataformas.fechasexcluidas fe WHERE fe.fecha BETWEEN historial_seguimiento.created_at and historial_seguimiento.updated_at)), ' dias') ELSE NULL END) AS Recogida"),
            DB::raw("MAX(CASE WHEN etapas_servicos.etapa = 'Ingreso taller' THEN CONCAT(IF(DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) = 0, 1, DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) - (SELECT  COUNT(*) FROM db_plataformas.fechasexcluidas fe WHERE fe.fecha BETWEEN historial_seguimiento.created_at and historial_seguimiento.updated_at)), ' dias') ELSE NULL END) AS Ingreso_taller"),
            DB::raw("MAX(CASE WHEN etapas_servicos.etapa = 'Salida taller' THEN CONCAT(IF(DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) = 0, 1, DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) - (SELECT  COUNT(*) FROM db_plataformas.fechasexcluidas fe WHERE fe.fecha BETWEEN historial_seguimiento.created_at and historial_seguimiento.updated_at)), ' dias') ELSE NULL END) AS Salida_taller"),
            DB::raw("MAX(CASE WHEN etapas_servicos.etapa = 'Entrega mercancía' THEN CONCAT(IF(DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) = 0,1,DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) - (SELECT  COUNT(*) FROM db_plataformas.fechasexcluidas fe WHERE fe.fecha BETWEEN historial_seguimiento.created_at and historial_seguimiento.updated_at)), ' dias') ELSE NULL END) AS Entrega_mercancía")
        )
            ->leftJoin('etapas_servicos', 'historial_seguimiento.id_proceso', '=', 'etapas_servicos.id')
            ->leftJoin('servicios_tecnicos', 'historial_seguimiento.id_St', '=', 'servicios_tecnicos.id_st')
            ->where('servicios_tecnicos.respuesta_st', '<>', 'Cobrable')
            ->groupBy('historial_seguimiento.id_st')
            ->orderByDesc('historial_seguimiento.id_st');


        if (!empty($this->fecha_i) && !empty($this->fecha_f)) {
            $query->whereBetween('servicios_tecnicos.created_at', [$this->fecha_i, $this->fecha_f]);
        } else if (!empty($this->fecha_i)) {
            $query->where('servicios_tecnicos.created_at', '>=', $this->fecha_i);
        } else if (!empty($this->fecha_f)) {
            $query->where('servicios_tecnicos.created_at', '<=', $this->fecha_f);
        } else {
            $query->whereBetween('servicios_tecnicos.created_at', [$this->fechaActual, $this->fechaFinMesActual]);
        }

        $data_ = $query->get();

        return $data_;
    }

    public function headings(): array
    {
        return [
            'OST',
            'Cedula',
            'Nombre',
            'Fecha',
            'Almacen',
            'Creación',
            'Visita',
            'Valoracion',
            'Recogida',
            'Ingreso Taller',
            'Salida Taller',
            'Entrega Mercancia'
        ];
    }

    public function title(): string
    {
        return 'Informe de tiempos de respuesta por etapa de orden de servicio';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // ODT
            'B' => 15,  // Cedula
            'C' => 40,  // Nombre
            'D' => 20,   // Fecha
            'E' => 20,   // Almacen
            'F' => 10,   // Creación
            'G' => 10,   // Visita
            'H' => 10,   // Valoracion
            'I' => 10,   // Recogida
            'J' => 15,   // Ingreso Taller
            'K' => 15,   // Salida Taller
            'L' => 20,   // Entrega Mercancia
        ];
    }
}
