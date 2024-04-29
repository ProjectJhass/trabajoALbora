<?php

namespace App\Exports;

use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportInfoServiciosTecnicos implements FromCollection, WithHeadings
{
    protected $fecha_i, $fecha_f, $almacen;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($fecha_i, $fecha_f, $almacen)
    {
        $this->fecha_i = $fecha_i;
        $this->fecha_f = $fecha_f;
        $this->almacen = $almacen;
    }

    public function collection()
    {
        if (empty($this->almacen)) {
            $data_ = ModelNuevaSolicitud::leftJoin('ingreso_taller as i', 'i.id_st', '=', 'servicios_tecnicos.id_st')
                ->whereBetween('servicios_tecnicos.created_at', [$this->fecha_i, $this->fecha_f])
                ->select(
                    'servicios_tecnicos.almacen',
                    'servicios_tecnicos.id_st',
                    'servicios_tecnicos.cantidad',
                    'servicios_tecnicos.articulo',
                    'i.orden_taller',
                    'servicios_tecnicos.respuesta_st',
                    'servicios_tecnicos.proceso',
                    'servicios_tecnicos.estado',
                    'servicios_tecnicos.created_at',
                )
                ->get();
        } else {
            $data_ = ModelNuevaSolicitud::leftJoin('ingreso_taller as i', 'i.id_st', '=', 'servicios_tecnicos.id_st')
                ->where('servicios_tecnicos.almacen', 'like', '%' . $this->almacen . '%')
                ->whereBetween('servicios_tecnicos.created_at', [$this->fecha_i, $this->fecha_f])
                ->select(
                    'servicios_tecnicos.almacen',
                    'servicios_tecnicos.id_st',
                    'servicios_tecnicos.cantidad',
                    'servicios_tecnicos.articulo',
                    'i.orden_taller',
                    'servicios_tecnicos.respuesta_st',
                    'servicios_tecnicos.proceso',
                    'servicios_tecnicos.estado',
                    'servicios_tecnicos.created_at',
                )
                ->get();
        }
        return $data_;
    }

    public function headings(): array
    {
        return [
            'almacen',
            'ost',
            'cantidad',
            'articulo',
            'orden de taller',
            'respuesta valoracion',
            'ubicación',
            'estado',
            'fecha elaboracion'
        ];
    }
}
