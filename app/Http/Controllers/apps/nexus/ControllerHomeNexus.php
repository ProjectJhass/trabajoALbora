<?php

namespace App\Http\Controllers\apps\nexus;

use App\Http\Controllers\Controller;
use App\Models\apps\nexus\ModelHistorialUsuarioManual;
use App\Models\apps\nexus\ModelInfoManualFunciones;
use App\Models\apps\nexus\ModelSeccionesManual;
use App\Models\apps\nexus\ModelUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerHomeNexus extends Controller
{
    public function index()
    {
        $id_usuario = Auth::user()->id;
        $general = self::getInfoSectionGeneral($id_usuario);
        return view('apps.nexus.app.home.home', ['general' => $general]);
    }

    public function getInfoSeccionUsuario(Request $request)
    {
        $id_usuario = Auth::user()->id;
        $seccion = $request->seccion;

        switch ($seccion) {
            case 'general':
                $vista = self::getInfoSectionGeneral($id_usuario);
                break;
            case 'perfil':
                $vista = self::getInfoSectionPerfil($id_usuario);
                break;
            case 'entrevista':
                $vista = self::getInfoSectionEntrevista($id_usuario);
                break;
            case 'modulos':
                $vista = self::getInfoSectionModulos($id_usuario);
                break;
            case 'manual':
                $vista = self::getInfoSectionManual($id_usuario);
                break;
        }

        return response()->json(['status' => true, 'vista' => $vista], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function getInfoSectionGeneral($id_usuario)
    {
        return view('apps.nexus.app.home.menu.general')->render();
    }

    public function getInfoSectionPerfil($id_usuario)
    {
        return view('apps.nexus.app.home.menu.perfil')->render();
    }

    public function getInfoSectionEntrevista($id_usuario)
    {
        return view('apps.nexus.app.home.menu.entrevista')->render();
    }

    public function getInfoSectionModulos($id_usuario)
    {
        return view('apps.nexus.app.home.menu.modulos')->render();
    }

    public function getInfoSectionManual($id_usuario)
    {
        $info_user = ModelUsuarios::where("documento", $id_usuario)->where("estado", "Activo")->first();
        $id_user = isset($info_user->id) ? $info_user->id : 0;
        $info_ = ModelHistorialUsuarioManual::where("id_usuario", $id_user)->where("estado", "Activo")->first();
        $id_manual = isset($info_->id_manual_funciones) ? $info_->id_manual_funciones : null;
        $secciones = ModelSeccionesManual::with(['subSecciones'])->get();
        $manual = ModelInfoManualFunciones::with(['funcionesGenerales'])->where("id_manual", $id_manual)->get();
        return view('apps.nexus.app.home.menu.manual_funciones', ['secciones' => $secciones, 'manual' => $manual])->render();
    }
}
