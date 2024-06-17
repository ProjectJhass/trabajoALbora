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
    protected $orden_servicio;
    public function __construct($orden_servicio)
    {
        $this->orden_servicio = $orden_servicio;
    }

    public function collection()
    {
        if (empty($this->orden_servicio)) {
            $data_ = ModelHistorialSeguimiento::select(
                'historial_seguimiento.id_st',
                DB::raw("MAX(servicios_tecnicos.cedula) AS cedula"),
                DB::raw("MAX(servicios_tecnicos.nombre) AS nombre"),
                DB::raw("MAX(servicios_tecnicos.created_at) AS fecha"),
                DB::raw("MAX(servicios_tecnicos.almacen) AS almacen"),
                DB::raw("MAX(CASE WHEN etapas_servicos.etapa = 'Creación' THEN CONCAT(IF(DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) = 0, 1, DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at)), ' dias') ELSE NULL END) AS Creación"),
                DB::raw("MAX(CASE WHEN etapas_servicos.etapa = 'Visita/Evidencias' THEN CONCAT(IF(DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) = 0, 1, DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at)), ' dias') ELSE NULL END) AS Visita_Evidencias"),
                DB::raw("MAX(CASE WHEN etapas_servicos.etapa = 'Valoracion' THEN CONCAT(IF(DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) = 0, 1, DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at)), ' dias') ELSE NULL END) AS Valoracion"),
                DB::raw("MAX(CASE WHEN etapas_servicos.etapa = 'Recogida' THEN CONCAT(IF(DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) = 0, 1, DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at)), ' dias') ELSE NULL END) AS Recogida"),
                DB::raw("MAX(CASE WHEN etapas_servicos.etapa = 'Ingreso taller' THEN CONCAT(IF(DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) = 0, 1, DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at)), ' dias') ELSE NULL END) AS Ingreso_taller"),
                DB::raw("MAX(CASE WHEN etapas_servicos.etapa = 'Salida taller' THEN CONCAT(IF(DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) = 0, 1, DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at)), ' dias') ELSE NULL END) AS Salida_taller"),
                DB::raw("MAX(CASE WHEN etapas_servicos.etapa = 'Entrega mercancía' THEN CONCAT(IF(DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at) = 0, 1, DATEDIFF(historial_seguimiento.updated_at,historial_seguimiento.created_at)), ' dias') ELSE NULL END) AS Entrega_mercancía")
            )
                ->leftJoin('etapas_servicos', 'historial_seguimiento.id_proceso', '=', 'etapas_servicos.id')
                ->leftJoin('servicios_tecnicos', 'historial_seguimiento.id_St', '=', 'servicios_tecnicos.id_st')
                ->where('servicios_tecnicos.respuesta_st', '<>', 'Cobrable')
                ->groupBy('historial_seguimiento.id_st')
                ->orderByDesc('historial_seguimiento.id_st')
                ->get();
        } else {
            $data_ = ModelHistorialSeguimiento::select(
                'historial_seguimiento.id_st',
                'etapas_servicos.id',
                'etapas_servicos.etapa',
                'etapas_servicos.dias',
                'servicios_tecnicos.almacen',
                'historial_seguimiento.created_at',
                DB::raw('DATEDIFF(historial_seguimiento.updated_at, historial_seguimiento.created_at) as diferencia')
            )
                ->join('etapas_servicos', 'historial_seguimiento.id_proceso', '=', 'etapas_servicos.id')
                ->join('servicios_tecnicos', 'servicios_tecnicos.id_st', '=', 'historial_seguimiento.id_st')
                ->leftJoin('crear_ost_web', 'servicios_tecnicos.id_st', '=', 'crear_ost_web.num_ost')
                ->where('servicios_tecnicos.respuesta_st', '<>', 'Cobrable')
                ->orderByDesc('historial_seguimiento.id_st')
                ->where('historial_seguimiento.id_st', 'like', "%{$this->orden_servicio}%")
                ->orWhere('servicios_tecnicos.cedula', 'like', "%{$this->orden_servicio}%")
                ->orWhere('crear_ost_web.n_ticket', 'like', "%{$this->orden_servicio}%")
                ->get();
        }
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
            'F' => 20,   // Creación
            'G' => 15,   // Visita
            'H' => 20,   // Valoracion
            'I' => 15,   // Recogida
            'J' => 20,   // Ingreso Taller
            'K' => 20,   // Salida Taller
            'L' => 25,   // Entrega Mercancia
        ];
    }
}
