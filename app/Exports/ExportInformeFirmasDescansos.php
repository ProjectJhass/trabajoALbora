<?php

namespace App\Exports;

use App\Models\apps\intranet\ModelFirmasDescansosCompensatorios;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportInformeFirmasDescansos implements FromCollection, WithHeadings
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
        $fecha_f = date("Y-m-d", strtotime($this->fecha_f . "+ 1 days"));
        return ModelFirmasDescansosCompensatorios::whereBetween("created_at", [$this->fecha_i, $fecha_f])
            ->get(
                [
                    "id",
                    "nombre",
                    "cedula",
                    "ciudad",
                    "depto",
                    "almacen",
                    "dominical_laborado",
                    "dia_compensatorio",
                    "nombre_firma",
                    "ip_firma", "hash_firma",
                    "observaciones",
                    "created_at",
                    "updated_at"
                ]
            );
    }

    public function headings(): array
    {
        return [
            'Id',
            'Nombre',
            'Cédula',
            'Ciudad',
            'Departamento',
            'Almacén',
            'Dominical laborado',
            'Día compensatorio',
            'Fotografía',
            'Ip orígen',
            'sesión',
            'observaciones',
            'fecha creación',
            'fecha última actualización'
        ];
    }
}
