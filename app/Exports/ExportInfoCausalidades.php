<?php

namespace App\Exports;

use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportInfoCausalidades implements FromCollection, WithHeadings, WithColumnWidths
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
        $query = ModelNuevaSolicitud::select('articulo', 'causales', 'created_at')
            ->whereNotNull('causales')
            ->where('causales', '!=', '');

        if (!empty($this->fecha_i) && !empty($this->fecha_f)) {
            $query->whereBetween('created_at', [$this->fecha_i, $this->fecha_f]);
        } else if (!empty($this->fecha_i)) {
            $query->where('created_at', '>=', $this->fecha_i);
        } else if (!empty($this->fecha_f)) {
            $query->where('created_at', '<=', $this->fecha_f);
        } else {
            $query->whereBetween('created_at', [$this->fechaActual, $this->fechaFinMesActual]);
        }
        $data_ = $query->get();
        // dd($data_);

        return $data_;
    }

    public function headings(): array
    {
        return [
            'Nombre item',
            'Causalidad',
            'Fecha_creacion'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 60,
            'B' => 40,
            'C' => 30
        ];
    }
}
