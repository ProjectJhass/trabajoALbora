<?php

namespace App\Exports;

use App\Models\apps\intranet\ModelDescargarInfoEventos;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportIngresosNovedades implements FromCollection, WithHeadings
{
    protected $fecha_i;
    protected $fecha_f;

    public function __construct(string $fecha_i, string $fecha_f)
    {
        $this->fecha_i = $fecha_i;
        $this->fecha_f = $fecha_f;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ModelDescargarInfoEventos::ObtenerInfoIngresosNovedades($this->fecha_i, $this->fecha_f);
    }

    public function headings(): array
    {
        return [
            'Cedula asesor',
            'Nombre asesor',
            'Almacen',
            'Fecha',
            'Hora ingreso',
            'Hora salida',
            'Hora re-ingreso',
            'Hora salida re-ingreso',
            'Novedades',
        ];
    }
}
