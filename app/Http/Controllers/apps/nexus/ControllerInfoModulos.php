<?php

namespace App\Http\Controllers\apps\nexus;

use App\Http\Controllers\Controller;
use App\Models\apps\nexus\ModelInfoAreas;
use App\Models\apps\nexus\ModelInfoCargos;
use App\Models\apps\nexus\ModelInfoModulos;
use App\Models\apps\nexus\ModelInfoTemasCapacitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerInfoModulos extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input("search", '');
    
        $areas = ModelInfoAreas::where('nombre_dpto', 'like', '%' . $searchTerm . '%')->get();
    
        $info =  view('apps.nexus.app.modulos_capacitacion.info.areas', ['info' => $areas])->render();
        return view('apps.nexus.app.modulos_capacitacion.areas', ['info' => $info, 'searchTerm' => $searchTerm]);
    }
    

    public function infoCargos(Request $request)
    {
        $id_area = $request->id_area;
        $cargos = ModelInfoCargos::where("id_departamento", $id_area)->get();
        $info =  view('apps.nexus.app.modulos_capacitacion.info.cargos', ['info' => $cargos, 'id_area' => $id_area])->render();
        return view('apps.nexus.app.modulos_capacitacion.cargos', ['info' => $info]);
    }

    public function infoModulos(Request $request)
    {
        $id_cargo = $request->id_cargo;
        $modulos = ModelInfoModulos::join("cargos_modulos as c", "c.id_modulo", "=", "modulos_capacitacion.id_modulo")->orderBy("nombre_modulo")->where("c.id_cargo", $id_cargo)->get();
        $info =  view('apps.nexus.app.modulos_capacitacion.info.modulos', ['info' => $modulos])->render();
        return view('apps.nexus.app.modulos_capacitacion.modulos', ['info' => $info]);
    }

    public function infoTemasCapacitacion(Request $request)
    {
        $id_modulo = $request->id_modulo;
        $temas = ModelInfoTemasCapacitacion::leftJoin("evaluaciones_temas as e", "e.id_tema_capacitacion", "=", "id_tema")
            ->select("temas_capacitacion.*", DB::raw("COUNT(e.id_tema_capacitacion) as cantidad_evaluaciones"))
            ->where("id_modulo", $id_modulo)->groupBy("temas_capacitacion.id_tema")->get();

        $info =  view('apps.nexus.app.modulos_capacitacion.info.temas', ['info' => $temas])->render();
        return view('apps.nexus.app.modulos_capacitacion.temas', ['info' => $info]);
    }

    public function getContenidoTemaCapacitacion(Request $request)
    {
        $id_tema = $request->id_tema;
        $tema = ModelInfoTemasCapacitacion::with(['infoEncargadoTema', 'evaluacionesCreadas', 'evaluacionesCreadas.getPreguntasEvaluacion'])
            ->where("id_tema", $id_tema)->get();
        $tema_ = $tema->first();
        $infoTema = view("apps.nexus.app.modulos_capacitacion.info.InfoTemas", ['item' => $tema_])->render();
        $infoEvaluaciones = view("apps.nexus.app.modulos_capacitacion.info.evaluaciones", ['info' => $tema_->evaluacionesCreadas])->render();

        return view('apps.nexus.app.modulos_capacitacion.temaContenido', ['item' => $tema_, 'tema' => $infoTema, 'evaluaciones' => $infoEvaluaciones]);
    }

    // Funcion para la eidicion de las areas de la empresa 

    public function EdicionArea(Request $request){
        
    }


    // public function EdicionArea(Request $request){
    //     $id_area = $request->id_area;

    //     // $AreaDpto= ModelInfoTemasAreaDpto::find($id_area);

    //     $area_depto_update = ModelInfoTemasAreaDpto::find($id_area);

    //     $descripcion = $area_depto_update->descripcion_dpto;

    
    //     $area_depto_update->descripcion_dpto = "Valor nuevo";
    //     $area_depto_update->save();

    // $area_depto_update = ModelInfoTemasAreaDpto::where("id_dpto", $id_area)
    // ->update(["descripcion_dpto" => "Valor nuevo"]);


    // $area = ModelInfoTemasAreaDpto::create([

    // ]);

    // $area->id_dpto;

    // }

    




}    