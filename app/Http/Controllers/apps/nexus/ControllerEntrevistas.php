<?php

namespace App\Http\Controllers\apps\nexus;

use App\Http\Controllers\Controller;
use App\Models\apps\nexus\ModelDepartamentos;
use App\Models\apps\nexus\ModelEntrevistasRealizadas;
use App\Models\apps\nexus\ModelExperienciaLaboral;
use App\Models\apps\nexus\ModelInformacionAspectosPersonales;
use App\Models\apps\nexus\ModelInformacionFamilia;
use App\Models\apps\nexus\ModelRespuestaAspectosPersonales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerEntrevistas extends Controller
{
    public function crearEntrevista()
    {
        $aspectos = ModelInformacionAspectosPersonales::all();
        $deptos = ModelDepartamentos::orderBy("depto")->get();
        return view('apps.nexus.app.entrevistas.crear', ['departamentos' => $deptos, 'aspectos' => $aspectos]);
    }

    public function validarInformacion(Request $request)
    {
        $etapa = $request->etapa;

        switch ($etapa) {
            case 'etapa1':
                for ($i = 1; $i <= 13; $i++) {
                    $campo = $request['info_b_c' . $i];
                    if (empty($campo)) {
                        return response()->json(['status' => false, 'mensaje' => '¡ERROR! Revisa los campos en rojo y/o vacios antes de seguir'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                    }
                }
                break;
            case 'etapa2':
                $cantidad_p = $request->cantidad_parentescos;
                for ($i = 1; $i <= $cantidad_p; $i++) {
                    $nombre = $request['nombre_p_e' . $i];
                    $parentesco = $request['parentesco_e' . $i];
                    $edad = $request['edad_p_e' . $i];
                    $ocupacion = $request['ocupacion_p_e' . $i];
                    if (empty($nombre) || empty($parentesco) || empty($edad) || empty($ocupacion)) {
                        return response()->json(['status' => false, 'mensaje' => '¡ERROR! Revisa los campos en rojo y/o vacios antes de seguir'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                    }
                }
                break;
            case 'etapa3':
                for ($i = 1; $i <= 14; $i++) {
                    $aspecto = $request['asp_p' . $i];
                    if (empty($aspecto)) {
                        return response()->json(['status' => false, 'mensaje' => '¡ERROR! Revisa los campos en rojo y/o vacios antes de seguir'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                    }
                }
                break;
            case 'etapa4':
                for ($i = 1; $i <= 2; $i++) {
                    $aspecto = $request['educacion' . $i];
                    if (empty($aspecto)) {
                        return response()->json(['status' => false, 'mensaje' => '¡ERROR! Revisa los campos en rojo y/o vacios antes de seguir'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                    }
                }
                break;
            case 'etapa5':
                $cantidad_ = $request->txtCantExpLab;

                for ($i = 1; $i <= $cantidad_; $i++) {
                    $empresa = $request['exp_lab_e' . $i];
                    $cargo = $request['exp_lab_c' . $i];
                    $periodo = $request['exp_lab_fech' . $i];
                    $funciones = $request['exp_lab_f' . $i];
                    $retiro = $request['exp_lab_m' . $i];
                    if (empty($empresa) || empty($cargo) || empty($funciones) || empty($retiro) || empty($periodo)) {
                        return response()->json(['status' => false, 'mensaje' => '¡ERROR! Revisa los campos en rojo y/o vacios antes de seguir'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                    }
                }
                break;
            case 'etapa6':
                for ($i = 15; $i <= 22; $i++) {
                    $aspecto = $request['asp_e' . $i];
                    if (empty($aspecto)) {
                        return response()->json(['status' => false, 'mensaje' => '¡ERROR! Revisa los campos en rojo y/o vacios antes de seguir'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
                    }
                }
                break;
        }

        return response()->json(['status' => true], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function crearInfoEntrevista(Request $request)
    {
        $entrevista = ModelEntrevistasRealizadas::create([
            'proceso' => $request['info_b_c1'],
            'sede' => $request['info_b_c2'],
            'fecha' => date('Y-m-d'),
            'cedula' => $request['info_b_c3'],
            'nombre' => $request['info_b_c4'],
            'apellidos' => $request['info_b_c5'],
            'id_dpto' => $request['info_b_c6'],
            'departamento' => $request->departamento,
            'id_ciudad' => $request['info_b_c7'],
            'ciudad' => $request->ciudad,
            'barrio' => $request['info_b_c8'],
            'direccion' => $request['info_b_c9'],
            'fecha_nacimiento' => $request['info_b_c10'],
            'edad' => $request['info_b_c11'],
            'cargo_aspira' => $request['info_b_c12'],
            'tipo_vivienda' => $request['info_b_c13'],
            'libreta_militar' => $request['info_b_c14'],
            'clase' => $request['info_b_c15'],
            'distrito' => $request['info_b_c16'],
            'camisa' => $request['info_b_c17'],
            'pantalon' => $request['info_b_c18'],
            'zapatos' => $request['info_b_c19'],
            'primaria' => $request['educacion1'],
            'secundaria' => $request['educacion2'],
            'profesional' => $request['educacion3'],
            'complementaria' => $request['educacion4'],
            'id_usuario' => Auth::user()->id,
            'usuario_creador' => Auth::user()->nombre,
            'estado' => 'En revision'
        ]);
        if ($entrevista) {
            $id_entrevista = $entrevista->id;

            //Agregar información del circulo familiar
            $cantidad_p = $request->cantidad_parentescos;
            for ($i = 1; $i <= $cantidad_p; $i++) {
                $nombre = $request['nombre_p_e' . $i];
                $parentesco = $request['parentesco_e' . $i];
                $edad = $request['edad_p_e' . $i];
                $ocupacion = $request['ocupacion_p_e' . $i];

                ModelInformacionFamilia::create([
                    'nombre' => $nombre,
                    'parentesco' => $parentesco,
                    'edad' => $edad,
                    'ocupacion' => $ocupacion,
                    'id_entrevista' => $id_entrevista
                ]);
            }

            //Agregar respuestas de aspectos personales
            for ($i = 1; $i <= 14; $i++) {
                $aspecto_ = ModelInformacionAspectosPersonales::find($i);
                $respuesta = $request['asp_p' . $i];
                ModelRespuestaAspectosPersonales::create([
                    'aspecto' => $aspecto_->aspecto,
                    'respuesta' => $respuesta,
                    'seccion' => '1',
                    'id_entrevista' => $id_entrevista
                ]);
            }

            //Agregar experiencia laboral
            $cantidad_ = $request->txtCantExpLab;

            for ($i = 1; $i <= $cantidad_; $i++) {
                $empresa = $request['exp_lab_e' . $i];
                $cargo = $request['exp_lab_c' . $i];
                $periodo = $request['exp_lab_fech' . $i];
                $funciones = $request['exp_lab_f' . $i];
                $retiro = $request['exp_lab_m' . $i];

                ModelExperienciaLaboral::create([
                    'empresa' => $empresa,
                    'cargo' => $cargo,
                    'periodo' => $periodo,
                    'funciones' => $funciones,
                    'retiro' => $retiro,
                    'id_entrevista' => $id_entrevista
                ]);
            }

            //Agregar aspectos empresariales
            for ($i = 15; $i <= 22; $i++) {
                $aspecto_ = ModelInformacionAspectosPersonales::find($i);
                $respuesta = $request['asp_e' . $i];
                ModelRespuestaAspectosPersonales::create([
                    'aspecto' => $aspecto_->aspecto,
                    'respuesta' => $respuesta,
                    'seccion' => '2',
                    'id_entrevista' => $id_entrevista
                ]);
            }

            return response()->json(['status' => true, 'mensaje' => '¡EXCELENTE! Información de la entrevista almacenada correctamente'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
