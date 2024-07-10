<?php

namespace App\Http\Controllers\apps\nexus;

use App\Http\Controllers\Controller;
use App\Models\apps\nexus\ModelFuncionesGeneralesManual;
use App\Models\apps\nexus\ModelHistorialUsuarioManual;
use App\Models\apps\nexus\ModelInfoManualFunciones;
use App\Models\apps\nexus\ModelSeccionesManual;
use App\Models\apps\nexus\ModelUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerManualFunciones extends Controller
{
    public function index()
    {
        $manuales = ModelInfoManualFunciones::where("estado", "Activo")->get();
        return view('apps.nexus.app.manual_funciones.registros', ['manuales' => $manuales]);
    }

    public function formulario()
    {
        $usuarios = ModelUsuarios::where("estado", "Activo")->get();
        $secciones = ModelSeccionesManual::with(['subSecciones'])->get();
        return view('apps.nexus.app.manual_funciones.formulario', ['usuarios' => $usuarios, 'secciones' => $secciones]);
    }

    public function crearManualFuncionesNexus(Request $request)
    {
        $id_empresa = $request->seccion_empresa;
        $id_area = $request->area_dependencia;
        $area = $request->nom_area;
        $id_cargo = $request->cargo_dependencia;
        $cargo = $request->nom_cargo;
        $operacion = $request->operacion_asignada;
        $jefe_inmediato = $request->jefe_inmediato;
        $autoridad_formal = $request->autoridad_formal;
        $objetivo_general = $request->objetivo_general;

        $count_m = ModelInfoManualFunciones::where("id_cargo", $id_cargo)->where("id_area", $id_area)->count();
        if ($count_m > 0) {
            ModelInfoManualFunciones::where("id_cargo", $id_cargo)->where("id_area", $id_area)->update(['estado' => 'Inactivo']);
        }

        $res_m = ModelInfoManualFunciones::create([
            'id_empresa'=>$id_empresa,
            'id_cargo' => $id_cargo,
            'cargo' => $cargo,
            'id_area' => $id_area,
            'area' => $area,
            'operacion_asignada' => $operacion,
            'jefe_inmediato' => $jefe_inmediato,
            'autoridad_formal' => $autoridad_formal,
            'objetivo_general' => $objetivo_general,
            'estado' => 'Activo',
            'usuario_actualizacion' => Auth::user()->nombre
        ]);

        if ($res_m) {
            $id_manual = $res_m->id_manual;
            $secciones = ModelSeccionesManual::with(['subSecciones'])->get();

            ModelHistorialUsuarioManual::where("id_area", $id_area)->where("id_cargo", $id_cargo)->where("estado", "Activo")->update(['id_manual_funciones' => $id_manual]);

            foreach ($secciones as $key => $value) {
                $id_seccion = $value->id_seccion;
                switch ($id_seccion) {
                    case '2':
                        $cantidad = $request['input' . $id_seccion];
                        if (empty($cantidad) || $cantidad == 0) {
                            $funcion_general = 'NA';
                            ModelFuncionesGeneralesManual::create([
                                'descripcion' => $funcion_general,
                                'id_manual' => $id_manual,
                                'id_seccion' => $id_seccion
                            ]);
                        } else {
                            for ($i = 1; $i <= $cantidad; $i++) {
                                $funcion_general = $request['funGeneral' . $id_seccion . '_' . $i];
                                ModelFuncionesGeneralesManual::create([
                                    'descripcion' => $funcion_general,
                                    'id_manual' => $id_manual,
                                    'id_seccion' => $id_seccion
                                ]);
                            }
                        }

                        break;
                    case '3':
                        $cantidad = $request['input' . $id_seccion];
                        if (empty($cantidad) || $cantidad == 0) {
                            $descripcion = "NA";
                            $relevancia = "";
                            $frecuencia = "";

                            ModelFuncionesGeneralesManual::create([
                                'descripcion' => $descripcion,
                                'relevancia' => $relevancia,
                                'frecuencia' => $frecuencia,
                                'id_manual' => $id_manual,
                                'id_seccion' => $id_seccion
                            ]);
                        } else {
                            for ($i = 1; $i <= $cantidad; $i++) {
                                $descripcion = $request['descripcion' . $id_seccion . '_' . $i];
                                $relevancia = $request['relevancia' . $id_seccion . '_' . $i];
                                $frecuencia = $request['frecuencia' . $id_seccion . '_' . $i];

                                ModelFuncionesGeneralesManual::create([
                                    'descripcion' => $descripcion,
                                    'relevancia' => $relevancia,
                                    'frecuencia' => $frecuencia,
                                    'id_manual' => $id_manual,
                                    'id_seccion' => $id_seccion
                                ]);
                            }
                        }

                        break;

                    default:
                        foreach ($value->subSecciones as $key => $val) {
                            $id_subseccion = $val->id_seccion_m;
                            $cantidad = $request['input' . $id_seccion . $id_subseccion];

                            if (empty($cantidad) || $cantidad == 0) {
                                $descripcion = "NA";
                                ModelFuncionesGeneralesManual::create([
                                    'descripcion' => $descripcion,
                                    'id_manual' => $id_manual,
                                    'id_seccion' => $id_seccion,
                                    'id_subseccion' => $id_subseccion
                                ]);
                            } else {
                                for ($i = 1; $i <= $cantidad; $i++) {
                                    $descripcion = $request['sub' . $id_subseccion . '_' . $i];

                                    ModelFuncionesGeneralesManual::create([
                                        'descripcion' => $descripcion,
                                        'id_manual' => $id_manual,
                                        'id_seccion' => $id_seccion,
                                        'id_subseccion' => $id_subseccion
                                    ]);
                                }
                            }
                        }
                        break;
                }
            }
            return response()->json(['status' => true, 'mensaje' => '¡EXCELENTE! Manual de funciones creado exitosamente'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }

        return response()->json(['status' => false], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function editarManual(Request $request)
    {
        $id_manual = $request->id_manual;
        $usuarios = ModelUsuarios::where("estado", "Activo")->get();
        $secciones = ModelSeccionesManual::with(['subSecciones'])->get();
        $manual = ModelInfoManualFunciones::with(['funcionesGenerales'])->where("id_manual", $id_manual)->get();
        return view('apps.nexus.app.manual_funciones.editarInfo', ['usuarios' => $usuarios, 'secciones' => $secciones, 'manual' => $manual]);
    }
}
