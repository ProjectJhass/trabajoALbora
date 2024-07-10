<?php

namespace App\Http\Controllers\apps\nexus;

use App\Http\Controllers\Controller;
use App\Models\apps\nexus\ModelEntrevistasRealizadas;
use Illuminate\Http\Request;

class ControllerEmitirConceptoEntrevista extends Controller
{
    public function index()
    {
        $vista = self::tableEntrevistas();
        return view("apps.nexus.app.entrevistas.enRevision", ['table' => $vista]);
    }

    public function tableEntrevistas()
    {
        $entrevistas = ModelEntrevistasRealizadas::where("estado", "En revision")->get();
        return view("apps.nexus.app.entrevistas.table.tableInfoConcepto", ["info" => $entrevistas])->render();
    }

    public function emitirConcepto(Request $request)
    {
        $id = $request->id;
        $entrevista = ModelEntrevistasRealizadas::with(['infoFamiliar', 'infoAspectosGenerales', 'infoExpLaboral'])->where("id", $id)->get();
        $entrevista_ = $entrevista->first();
        return view("apps.nexus.app.entrevistas.darConcepto", ['darConcepto' => $entrevista_]);
    }
}
