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

    public function CreacionAreaUsuarios($areaId, $usuarios)
    {
        // Si $areaId no es un array, conviértelo en un array
        if (!is_array($areaId)) {
            $areaId = [$areaId];
        }
    
        // Si $usuarios no es un array, conviértelo en un array
        if (!is_array($usuarios)) {
            $usuarios = [$usuarios];
        }
    
        // Validar que se reciban usuarios e ID de área
        if (empty($usuarios) || empty($areaId)) {
            return response()->json(['status' => false], 400);
        }
    
        // Crear la relación en la base de datos para cada usuario y área
        foreach ($areaId as $areasId) {
            foreach ($usuarios as $usuarioId) {
                ModelAreasUsuarios::create([
                    'id' => $usuarioId, // Asegúrate de usar el campo correcto
                    'id_dpto' => $areasId,
                ]);
            }
        }
    
        return response()->json(['status' => true], 201);
    }
    
    
    
}





