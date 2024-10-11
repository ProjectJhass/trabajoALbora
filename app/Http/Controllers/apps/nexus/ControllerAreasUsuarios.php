<?php
namespace App\Http\Controllers\apps\nexus;

use App\Http\Controllers\Controller;
use App\Models\apps\nexus\ModelAreasUsuarios;
use Illuminate\Http\Request;

class ControllerAreasUsuarios extends Controller
{
    public function index()
    {
        // Aquí puedes realizar una consulta general de los datos de usuarios por área
        $usuarios = ModelAreasUsuarios::all();
        return response()->json($usuarios, 200);
    }

    public function CreacionAreaUsuarios(array $usuarios, $areaId)
    {
        // Validar que se reciban usuarios e ID de área
        if (empty($usuarios) || empty($areaId)) {
            return response()->json(['status' => false, 'mensaje' => 'Faltan datos necesarios.'], 400);
        }
    
        // Crear la relación en la base de datos para cada usuario
        foreach ($usuarios as $usuarioId) {
            ModelAreasUsuarios::create([
                'id' => $usuarioId, // Asegúrate de usar el campo correcto
                'id_dpto' => $areaId,
            ]);
        }
    
        return response()->json(['status' => true, 'mensaje' => 'Usuarios asignados al área exitosamente.'], 201);
    }
    
}





