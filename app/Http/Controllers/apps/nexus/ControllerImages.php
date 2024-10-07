<?php

namespace App\Http\Controllers\apps\nexus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ControllerImages extends Controller
{
    public function uploadImage ($file){

        if ($file->isValid()&& $file->isImage()) {
            $filename=time(). ".".$file->getClientOriginalExtension();
        
            $file->storeAs('images',$filename,'public');
            
            
            return $filename;
        }

        throw new \Exception("El archivo no es una imagen válida."); // Manejo de errores

    }


   
}
