<?php

namespace App\Exports;

use App\Models\apps\crm_almacenes\ModelClientesCRM;
use App\Models\apps\intranet\ModelDescargarInfoEventos;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportClientesCRM implements FromCollection, WithHeadings
{
    protected $fecha_i;
    protected $fecha_f;
    protected $tipo_cliente;
    protected $almacen;
    protected $asesor;
    public function __construct($tipo_cliente = null, $fecha_i = null, $fecha_f = null, $almacen = null, $asesor = null)
    {
        $this->fecha_i = $fecha_i;
        $this->fecha_f = $fecha_f;
        $this->tipo_cliente = $tipo_cliente;
        $this->almacen = $almacen;
        $this->asesor = $asesor;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $export = ModelClientesCRM::select(
            'id_cliente',
            'cedula_cliente',
            DB::raw('CONCAT(nombre_1, " " , nombre_2) as nombres'),
            DB::raw('CONCAT(apellido_1, " ",apellido_2) as apellidos'),
            'ciudad',
            'barrio',
            'direccion',
            'email',
            'celular_1',
            'celular_2',
            'fecha_registro',
            'tipo_cliente',
            'clientes_crm.estado',
            'co.nombre as asesor',
            'co.sucursal'
        )
            ->join('users as co', 'cedula_asesor', '=', 'co.id');
        if (!empty($this->tipo_cliente) && $this->tipo_cliente < 5) {
            $export->where('tipo_cliente', $this->tipo_cliente);
        } else if (!empty($this->tipo_cliente) && $this->tipo_cliente >= 5) {
            $export->where('clientes_crm.estado', $this->tipo_cliente);
        }
        if (!empty($this->asesor)) {
            $export->where('cedula_asesor', $this->asesor);
        }

        if (!empty($this->almacen)) {
            $export->where('co.sucursal', $this->almacen);
        }
        if (!empty($this->fecha_i) && !empty($this->fecha_f)) {
            $export->whereBetween('fecha_registro', [$this->fecha_i, $this->fecha_f]);
        } elseif (!empty($this->fecha_i)) {
            $export->where('fecha_registro', '>=', $this->fecha_i);
        } elseif (!empty($this->fecha_f)) {
            $export->where('fecha_registro', '<=', $this->fecha_f);
        }
        $response = $export->get();
        $tipos_cliente_1 = [
            0 => 'Eliminar',
            1 => 'Oportunidad',
            2 => 'Prospecto',
            3 => 'Efectivo',
            4 => 'Eliminar'
        ];
        $tipos_cliente_2 = [
            5 => 'Preferencial',
            6 => 'Pre Aprobado'
        ];
        $response = $response->map(function ($item) use ($tipos_cliente_1) {
            $item->tipo_cliente = $tipos_cliente_1[$item->tipo_cliente] ?? '';
            return $item;
        });
        $response = $response->map(function ($item) use ($tipos_cliente_2) {
            $item->estado = $tipos_cliente_2[$item->estado] ?? '';
            return $item;
        });
        return $response;
    }

    public function headings(): array
    {
        return [
            'ID Cliente',
            'Cedula',
            'Nombres',
            'Apellidos',
            'Ciudad',
            'Barrio',
            'Direccion',
            'Email',
            'Celular 1',
            'Celular 2',
            'Fecha registro',
            'Tipo de cliente 1',
            'Tipo de cliente 2',
            'Nombre Asesor',
            'Centro de Operación'
        ];
    }
}
