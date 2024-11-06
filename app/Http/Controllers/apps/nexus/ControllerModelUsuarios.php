<?php

namespace App\Http\Controllers\apps\nexus;

use App\Http\Controllers\Controller;
use App\Models\apps\nexus\ModelModuloUsuarios;
use Illuminate\Http\Request;


class ControllerModelUsuarios extends Controller
{
    public function index() {
        $modelUsuarios=ModelModuloUsuarios::all();
        return response()->json($modelUsuarios,200);
    }
    public function crearModuloUsuarios(array $usuarios, $moduloId){
        if (empty($usuarios) || empty($moduloId)) {
            return response()->json(['status' => false, 'mensaje' => 'Faltan datos necesarios.'], 400);
 
        }


        foreach ($usuarios as $IdUsuarios) {
            ModelModuloUsuarios::create([
                'id'=> $IdUsuarios,
                'id_modulo'=> $moduloId,
            ]);
        }
        return response()->json(['status' => true, 'mensaje' => 'Usuarios asignado al modulo exitosamente.'], 201);

    }
}







