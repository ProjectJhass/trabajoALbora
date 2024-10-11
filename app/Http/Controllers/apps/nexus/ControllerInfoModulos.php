<?php

namespace App\Http\Controllers\apps\nexus;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet\ModelUsersIntranet;
use App\Models\apps\nexus\ModelEmpresa;
use App\Models\apps\nexus\ModelInfoAreas;
use App\Models\apps\nexus\ModelInfoCargos;
use App\Models\apps\nexus\ModelInfoModulos;
use App\Models\apps\nexus\ModelInfoTemasCapacitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $id_area = $request->route('id_area');
        $cargos = ModelInfoCargos::where("id_departamento", $id_area)->get();
        $info = view('apps.nexus.app.modulos_capacitacion.info.cargos', [
            'info' => $cargos,
            'id_area' => $id_area
        ])->render();
        return view('apps.nexus.app.modulos_capacitacion.cargos', ['info' => $info]);
    }

    public function infoModulos(Request $request)
    {
        $id_cargo = $request->route('id_cargo');
        $modulos = ModelInfoModulos::join("cargos_modulos as c", "c.id_modulo", "=", "modulos_capacitacion.id_modulo")->orderBy("nombre_modulo")->where("c.id_cargo", $id_cargo)->get();
        $info =  view('apps.nexus.app.modulos_capacitacion.info.modulos', [
            'info' => $modulos,
            'id_cargo' => $id_cargo
        ])->render();
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

    // Funcion para la creacion de las areas de la empresa 

    public function crearArea()
    {
        return view('apps.nexus.app.modulos_capacitacion.Blade_Area.creacion');
    }
    public function store(Request $request)
    {
        return $this->storeArea($request);
    }
    private function storeArea(Request $request)
    {
        $validatedData = $request->validate([
            'nombre_dpto' => 'required|string|max:255',
            'descripcion_dpto' => 'nullable|string',
            'name_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'select_usuario_seleccionado' => 'required|array',
        ]);

        $seccion_empresa = Auth::user()->seccion_empresa;
        $contentEmpresa = ModelEmpresa::where('nombre_empresa', $seccion_empresa)->first();

        if (!$contentEmpresa) {
            return response()->json(['status' => false, 'mensaje' => 'No se encontró una empresa para esta sección.'], 404);
        }

        $validatedData['id_empresa'] = $contentEmpresa->id_empresa;

        $imageUploadController = new ControllerImages();

        try {
            if ($request->hasFile('name_image')) {
                $fileName = $imageUploadController->uploadImage($request->file('name_image'));
                $validatedData['name_image'] = $fileName;
            }
        } catch (\Throwable $e) {
            return response()->json(['status' => false, 'mensaje' => 'Hubo un error al subir la imagen!', 'error' => $e->getMessage()], 500);
        }

        $area = ModelInfoAreas::create($validatedData);

        $ControllerAreaUsuarios = new ControllerAreasUsuarios();

        foreach ($validatedData['select_usuario_seleccionado'] as $usuarioId) {
            $respuesta = $ControllerAreaUsuarios->CreacionAreaUsuarios([$usuarioId], $area->id_dpto);

            $respuestaData = $respuesta->getData();

            if ($respuestaData->status === false) {
                return response()->json(['status' => false, 'mensaje' => 'No se logró asignar el área a los usuarios'], 500);
            }
        }

        return response()->json(['status' => true, 'mensaje' => 'Área creada exitosamente.'], 200);
    }



    // Funcion para la creacion de los cargos de las areas de la empresa 

    public function crearCargo(Request $request)
    {
        return view('apps.nexus.app.modulos_capacitacion.Blade_Cargos.creacionForm', ['id_area' => $request->id_area]);
    }
    public function storee(Request $request)
    {
        return $this->storeCargo($request);
    }
    private function storeCargo(Request $request)
    {
        $validateData = $request->validate([
            'nombre_cargo' => 'required|string|max:255',
            'descripcion_cargo' => 'nullable|string',
            'name_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'select_usuario_seleccionado' => 'required|array',
        ]);

        $validateData['id_departamento'] = $request->id_area;

        $imageUploadController = new ControllerImages();

        try {
            if ($request->hasFile('name_image')) {
                $fileName = $imageUploadController->uploadImage($request->file('name_image'));
                $validateData['name_image'] = $fileName;
            }
        } catch (\Throwable $e) {
            return response()->json(['status' => false, 'mensaje' => 'Hubo un error al subir la imagen!', 'error' => $e->getMessage()], 500);
        }

        $cargo = ModelInfoCargos::create($validateData);

        $ControllerCargoUsuarios = new ControllerCargoUsuarios();

        foreach ($validateData['select_usuario_seleccionado'] as $usuariosId) {
            $respuesta = $ControllerCargoUsuarios->CreacionCargoUsuarios([$usuariosId], $cargo->id_cargo);

            $respuestaData = $respuesta->getData();

            if ($respuestaData->status === false) {
                return response()->json(['status' => false, 'mensaje' => 'No se logró asignar el área a los usuarios'], 500);
            }

            return response()->json(['status' => true, 'mensaje' => 'Cargo creado exitosamente'], 201);
        }
    }


    public function crearModulo(Request $request)
    {
        return view('Apps.nexus.app.modulos_capacitacion.Blade_Modulo.creacionForm', ['id_cargo' => $request->id_cargo]);
    }
    public function stores(Request $request)
    {

        return $this->storeModulo($request);
    }
    private function storeModulo(Request $request)
    {
        $validateData=$request->validate([
            'nombre_modulo'=> 'required|string|max:255',
            'descripcion_modulo'=> 'nullable|string',
            'name_image'=> 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado'=> 'required|string|max:150',
            'select_usuario_seleccionado'=> 'required|array',
        ]);

        $IDCargo= $request->id_cargo;

        $imageUploadController = new ControllerImages();

        try {
            if ($request->hasFile('name_image')) {
                $fileName = $imageUploadController->uploadImage($request->file('name_image'));
                $validateData['name_image'] = $fileName;
            }
        } catch (\Throwable $e) {
            return response()->json(['status' => false, 'mensaje' => 'Hubo un error al subir la imagen!', 'error' => $e->getMessage()], 500);
        }



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
