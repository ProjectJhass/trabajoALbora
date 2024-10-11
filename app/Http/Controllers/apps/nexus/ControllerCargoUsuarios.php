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

    public function CreacionCargoUsuarios(array $datos, $id_cargo){
           // Validar que se reciban usuarios e ID de área
           if (empty($datos) || empty($id_cargo)) {
            return response()->json(['status' => false, 'mensaje' => 'Faltan datos necesarios.'], 400);
        }
    
        // Crear la relación en la base de datos para cada usuario
        foreach ($datos as $usuarioId) {
            ModelCargoUsuarios::create([
                'id' => $usuarioId, // Asegúrate de usar el campo correcto
                'id_cargo' => $id_cargo,
            ]);
        }
    
        return response()->json(['status' => true, 'mensaje' => 'Usuarios asignados al cargo exitosamente.'], 201);
    }

}









