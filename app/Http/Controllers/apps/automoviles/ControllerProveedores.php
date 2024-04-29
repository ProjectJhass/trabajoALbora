<?php

namespace App\Http\Controllers\apps\automoviles;

use App\Http\Controllers\Controller;
use App\Models\apps\automoviles\ModelProveedores;
use Illuminate\Http\Request;

class ControllerProveedores extends Controller
{
    public function index()
    {
        $info = ModelProveedores::all();
        return view('apps.automoviles.proveedores.proveedores', ['info' => $info]);
    }
}
