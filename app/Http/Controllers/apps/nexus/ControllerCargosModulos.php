<?php

namespace App\Http\Controllers\apps\nexus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\apps\nexus\ModelCargosModulo;

class ControllerCargosModulos extends Controller
{
    public function index(){
        $cargos_modulo=ModelCargosModulo::all();
        return response()->json($cargos_modulo, 200);
    }

    public function CrearCargosModulo($id_cargo, $id_modulo, $estado){
        if (empty($estado) || empty($id_cargo) || empty($id_modulo)) {
            return response()->json(['status' => false, 'mensaje' => 'Faltan datos necesarios.'], 400);
        }
        
            ModelCargosModulo::create([
                'id_cargo'=> $id_cargo,
                'id_modulo'=> $id_modulo,
                'estado'=> $estado
            ]);
            return response()->json(['status' => true, 'mensaje' => 'Modulo asignado al cargo exitosamente.'], 201);
    }

}
