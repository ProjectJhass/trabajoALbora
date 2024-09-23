<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\servicios;

use App\Http\Controllers\Controller;
use App\Models\apps\servicios_tecnicos\servicios\ModelNuevaSolicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerInfoAlmacenes extends Controller
{

    public function solicitudesTable($data_info)
    {
        return view('apps.servicios_tecnicos.servicios_tecnicos.almacen.table', ['st' => $data_info])->render();
    }

    public function procesoData()
    {
        $almacen = Auth::user()->almacen;

        if ($almacen == 'BODEGA_021') {
            $valoracion = ModelNuevaSolicitud::where(function ($query) use ($almacen) {
                $query->where('almacen', $almacen)
                    ->orWhere('almacen', 'IBAGUE_004')
                    ->orWhere('almacen', 'NEIVA_012')
                    ->orWhere('almacen', 'NEIVA_025');
            })->where('proceso', 'Almacen')->where('estado', 'Recoger')->count();
            $respuesta = ModelNuevaSolicitud::where(function ($query) use ($almacen) {
                $query->where('almacen', $almacen)
                    ->orWhere('almacen', 'IBAGUE_004')
                    ->orWhere('almacen', 'NEIVA_012')
                    ->orWhere('almacen', 'NEIVA_025');
            })->where('proceso', 'Servicio tecnico')->where('estado', 'En devolucion')->count();
            $data_info = ModelNuevaSolicitud::where(function ($query) use ($almacen) {
                $query->where('almacen', $almacen)
                    ->orWhere('almacen', 'IBAGUE_004')
                    ->orWhere('almacen', 'NEIVA_012')
                    ->orWhere('almacen', 'NEIVA_025');
            })->where('proceso', 'Almacen')->where('estado', 'Recoger')->get();
        } else if ($almacen == "MANIZALES_017") {
            $valoracion = ModelNuevaSolicitud::where(function ($query) use ($almacen) {
                $query->where('almacen', $almacen)
                    ->orWhere('almacen', 'MANIZALES_017');
            })->where('estado', 'Por ingresar')->count();
            $respuesta = ModelNuevaSolicitud::where(function ($query) use ($almacen) {
                $query->where('almacen', $almacen)
                    ->orWhere('almacen', 'MANIZALES_017');
            })->where('estado', 'En devolucion')->count();
            $data_info = ModelNuevaSolicitud::where(function ($query) use ($almacen) {
                $query->where('almacen', $almacen)
                    ->orWhere('almacen', 'MANIZALES_017');
            })->where('estado', 'Por ingresar')->get();
        } else {
            $valoracion = ModelNuevaSolicitud::where('almacen', $almacen)->where('proceso', 'Almacen')->where('estado', 'Recoger')->count();
            $respuesta = ModelNuevaSolicitud::where('almacen', $almacen)->where('proceso', 'Servicio tecnico')->where('estado', 'En devolucion')->count();
            $data_info = ModelNuevaSolicitud::where('almacen', $almacen)->where('proceso', 'Almacen')->where('estado', 'Recoger')->get();
        }

        $table = self::solicitudesTable($data_info);
        return view('apps.servicios_tecnicos.servicios_tecnicos.almacen.seguimiento', ['table' => $table, 'recoger' => $valoracion, 'definir' => $respuesta]);
    }

    public function infoGeneral(Request $request)
    {
        $estado = $request->estado;
        $almacen = Auth::user()->almacen;

        if ($almacen == 'BODEGA_021') {
            switch ($estado) {
                case 'recoger':
                    $data_info = ModelNuevaSolicitud::where(function ($query) use ($almacen) {
                        $query->where('almacen', $almacen)
                            ->orWhere('almacen', 'IBAGUE_004')
                            ->orWhere('almacen', 'NEIVA_012')
                            ->orWhere('almacen', 'NEIVA_025');
                    })->where('proceso', 'Almacen')->where('estado', 'Recoger')->get();
                    break;
                case 'definir':
                    $data_info = ModelNuevaSolicitud::where(function ($query) use ($almacen) {
                        $query->where('almacen', $almacen)
                            ->orWhere('almacen', 'IBAGUE_004')
                            ->orWhere('almacen', 'NEIVA_012')
                            ->orWhere('almacen', 'NEIVA_025');
                    })->where('proceso', 'Servicio tecnico')->where('estado', 'En devolucion')->get();
                    break;
            }
        } else {
            switch ($estado) {
                case 'recoger':
                    $data_info = ModelNuevaSolicitud::where('almacen', $almacen)->where('proceso', 'Almacen')->where('estado', 'Recoger')->get();
                    break;
                case 'definir':
                    $data_info = ModelNuevaSolicitud::where('almacen', $almacen)->where('proceso', 'Servicio tecnico')->where('estado', 'En devolucion')->get();
                    break;
            }
        }

        $table = self::solicitudesTable($data_info);
        return response()->json(['table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
