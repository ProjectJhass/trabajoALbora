<?php
namespace App\Http\Controllers\apps\nexus;


use App\Http\Controllers\Controller;
use App\Models\apps\nexus\ModelCargoUsuarios;
use Illuminate\Http\Request;

class ControllerCargoUsuarios extends Controller{
    public function index(){
        $modelCargoUsuarios = ModelCargoUsuarios::all();
        return response()->json($modelCargoUsuarios, 200);
    }

    public function CreacionCargoUsuarios($datos, $id_cargo, $id_dpto) {
        // Validar que se reciban usuarios e ID de área
        if ((empty($datos) && is_array($datos)) && empty($id_cargo)) {
            return response()->json(['status' => false, 'mensaje' => 'Faltan datos necesarios.'], 400);
        }
    
        // Normalizar datos a array si no lo es
        if (!is_array($datos)) {
            $datos = [$datos]; // Convertir a array si es un solo valor
        }
    
        // Normalizar id_cargo a array si no lo es
        if (!is_array($id_cargo)) {
            $id_cargo = [$id_cargo]; // Convertir a array si es un solo valor
        }
    
        // Crear la relación en la base de datos para cada usuario
        foreach ($datos as $usuarioId) {
            foreach ($id_cargo as $cargoId) {
                ModelCargoUsuarios::create([
                    'id' => $usuarioId, // Asegúrate de usar el campo correcto
                    'id_cargo' => $cargoId,
                    'id_dpto' => $id_dpto,
                ]);
            }
        }
    
        return response()->json(['status' => true, 'mensaje' => 'Usuarios asignados al cargo exitosamente.'], 201);
    }
    

}









