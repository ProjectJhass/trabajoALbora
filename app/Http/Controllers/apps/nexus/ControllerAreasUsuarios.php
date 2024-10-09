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

    public function CreacionAreaUsuarios( $usuariosId, $areaId)
    {
        // Validar que se reciban usuarios e ID de área
        if (empty($usuariosId) || empty($areaId)) {
            return response()->json(['status' => false, 'mensaje' => 'Faltan datos necesarios.'], 400);
        }

        // Crear la relación en la base de datos
        foreach ($usuariosId as $usuarioId) {
            ModelAreasUsuarios::create([
                'usuario_id' => $usuarioId,
                'area_id' => $areaId,
            ]);
        }

        return response()->json(['status' => true, 'mensaje' => 'Usuarios asignados al área exitosamente.'], 201);
    }
}





