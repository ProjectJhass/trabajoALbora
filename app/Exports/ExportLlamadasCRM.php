<?php

namespace App\Exports;

use App\Models\apps\crm_almacenes\ModelClientesCRM;
use App\Models\apps\crm_almacenes\ModelInfoAsesores;
use App\Models\apps\crm_almacenes\ModelInfoLlamadasPendientes;
use App\Models\apps\intranet\ModelDescargarInfoEventos;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportLlamadasCRM implements FromCollection, WithHeadings
// , WithMapping
{
    protected $fecha_i;
    protected $fecha_f;
    protected $estado;
    protected $almacen;
    protected $asesor;
    public function __construct($estado = null, $fecha_i = null, $fecha_f = null, $almacen = null, $asesor = null)
    {
        $this->fecha_i = $fecha_i;
        $this->fecha_f = $fecha_f;
        $this->estado = $estado;
        $this->almacen = $almacen;
        $this->asesor = $asesor;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $export = ModelInfoLlamadasPendientes::whereHas('cliente')->with('cliente', 'cliente.asesoresCRM')
            ->where('estado', $this->estado);


        if (!empty($this->fecha_i) && !empty($this->fecha_f)) {
            $export->whereBetween('fecha_a_llamar', [$this->fecha_i, $this->fecha_f]);
        } elseif (!empty($this->fecha_i)) {
            $export->where('fecha_a_llamar', '>=', $this->fecha_i);
        } elseif (!empty($this->fecha_f)) {
            $export->where('fecha_a_llamar', '<=', $this->fecha_f);
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
            $item->cliente->tipo_cliente = $tipos_cliente_1[$item->cliente->tipo_cliente] ?? '';
            return $item;
        });
        $response = $response->map(function ($item) use ($tipos_cliente_2) {
            $item->cliente->estado = $tipos_cliente_2[$item->cliente->estado] ?? '';
            return $item;
        });
        return $response->map(function ($llamada) {
            return [
                $llamada->id_llamada,
                $llamada->fecha_a_llamar,
                $llamada->estado,
                $llamada->cliente->id_cliente,
                $llamada->cliente->cedula_cliente,
                $llamada->cliente->nombre_1 . ' ' . $llamada->cliente->nombre_2,
                $llamada->cliente->apellido_1 . ' ' . $llamada->cliente->apellido_2,
                $llamada->cliente->ciudad,
                $llamada->cliente->barrio,
                $llamada->cliente->direccion,
                $llamada->cliente->email,
                $llamada->cliente->celular_1,
                $llamada->cliente->celular_2,
                $llamada->cliente->fecha_registro,
                $llamada->cliente->tipo_cliente,
                $llamada->cliente->estado,
                $llamada->cliente->asesoresCRM->first() ? $llamada->cliente->asesoresCRM->first()->nombre : '',
                $llamada->cliente->asesoresCRM->first() ? $llamada->cliente->asesoresCRM->first()->sucursal : ''
            ];
        });;
    }

    public function headings(): array
    {
        return [
            'Id Llamada',
            'Fecha a llamar',
            'Estado llamada',
            'Id Cliente',
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
