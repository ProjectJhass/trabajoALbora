<?php

namespace App\Exports;

use App\Models\apps\intranet_fabrica\ModelSolicitudesMtto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SolicitudesMttoFecha implements FromCollection, WithHeadings
{
    protected $products, $fecha_i, $fecha_f;

    public function __construct($fecha_i = '2015-01-01', $fecha_f='2050-12-31')
    {
        $this->fecha_i = $fecha_i;
        $this->fecha_f = $fecha_f;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $solicitudes = ModelSolicitudesMtto::ObtenerSolicitudesPorRangoFecha($this->fecha_i, $this->fecha_f);
        return $solicitudes;
    }

    public function headings(): array
    {
        return [
            'Id Solicitud',
            'Solicitud',
            'Sección',
            'Máquina',
            'Responsable solicitud',
            'Fecha solicitud',
            'Respuesta solicitud',
            'Responsable de respuesta',
            'Fecha de respuesta',
            'Responsable quien recibe',
            'fecha recepción',
            'estado de la solicitud'
        ];
    }
}
