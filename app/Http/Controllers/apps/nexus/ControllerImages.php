<?php

namespace App\Http\Controllers\apps\nexus;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ControllerImages extends Controller
{
    public function uploadImage($file)
    {
        // Verificar si el archivo es válido y es una imagen
        if ($file && $file->isValid() && in_array($file->getClientMimeType(), ['image/jpeg', 'image/png', 'image/gif'])) {

            // Generar un nombre único para la imagen
            $filename = time() . "." . $file->getClientOriginalExtension();

            // Definir la ruta completa donde se guardará la imagen
            $destinationPath = public_path('assets/img/ImageAreas');

            // Verificar si la carpeta existe, si no, crearla
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Mover la imagen a la ruta especificada
            $file->move($destinationPath, $filename);

            // Retornar solo el nombre del archivo
            return $filename;
        }

        // Lanzar una excepción si el archivo no es válido o no es una imagen
        throw new \Exception("El archivo no es una imagen válida.");
    }
}

