<?php

namespace App\Exports;

use App\Models\apps\crm_almacenes\ModelClientesCRM;
use App\Models\apps\crm_almacenes\ModelItemsCotizadosCrm;
use App\Models\apps\intranet\ModelDescargarInfoEventos;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportCotizacionesCRM implements FromCollection, WithHeadings
{
    protected $fecha_i;
    protected $fecha_f;
    protected $almacen;
    protected $asesor;
    public function __construct($fecha_i = null, $fecha_f = null, $almacen = null, $asesor = null)
    {
        $this->fecha_i = $fecha_i;
        $this->fecha_f = $fecha_f;
        $this->almacen = $almacen;
        $this->asesor = $asesor;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $export = ModelItemsCotizadosCrm::select(
            'idsession',
            'sku',
            'producto',
            'vlr_credito',
            'dsto_adicional',
            'plan',
            'descuento',
            'asesor',
            'fecha',
            'cotizaciones.sucursal'
        )->join('users as co', 'asesor', '=', 'co.nombre');


        if (!empty($this->asesor)) {
            $export->where('co.id', $this->asesor);
        }

        if (!empty($this->almacen)) {
            $export->where('co.sucursal', $this->almacen);
        }
        if (!empty($this->fecha_i) && !empty($this->fecha_f)) {
            $export->whereBetween('fecha', [$this->fecha_i, $this->fecha_f]);
        } elseif (!empty($this->fecha_i)) {
            $export->where('fecha', '>=', $this->fecha_i);
        } elseif (!empty($this->fecha_f)) {
            $export->where('fecha', '<=', $this->fecha_f);
        }
        return $export->get();
    }

    public function headings(): array
    {
        return [
            'id sesión',
            'Sku',
            'Producto',
            'Valor Credito',
            'Descuento Adicional',
            'Plan',
            'Descuento',
            'Asesor',
            'fecha',
            'Sucursal'
        ];
    }
}
