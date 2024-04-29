<?php

namespace App\Http\Controllers\apps\intranet_fabrica;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet_fabrica\ModelMantenimientos;
use App\Models\apps\intranet_fabrica\ModelUsuarios;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerMantenimiento extends Controller
{
    protected $hoy;

    public function __construct()
    {
        $this->hoy = date('Y-m-d');
    }

    public function validarFecha($fecha)
    {

        return ($fecha >= Carbon::now()->format('Y-m-d')) ? true : false;
    }


    public function validateUser()
    {
        return Auth::user()->rol;
    }

    public function checkState()
    {

        // función que cambia de estado el mantenimiento pasados 6 días
        $fechas = $this->hoy;
        $fecha_min = date("Y-m-d", strtotime($fechas . "- 7 days"));
        $hoy = new DateTime($fechas);
        $datos = ModelMantenimientos::checkValidate($fecha_min);

        foreach ($datos as $value) {
            $fecha_mantenice = $value->fecha_mantenimiento;
            $fecha_manten = new DateTime($fecha_mantenice);
            $cal = $hoy->diff($fecha_manten)->d;
            if ($fecha_mantenice < $fechas && $cal > 6) {

                ModelMantenimientos::changeStatus($value->id_mantenimiento);
            }
        }
    }

    public function getAllMantenices()
    {
        //self::checkState(); por si se desea cambiar de estado el mantenimiento pasados 6 dias

        $datos = ModelMantenimientos::getAllMantenices();
        $mantenimientos = [];
        $self_rol = Auth::user()->rol_user;

        foreach ($datos as $value) {

            array_push($mantenimientos, [

                'referencia' => $value->referencia,
                'nombre_maquina' => $value->nombre_maquina,
                'observacion' => $value->observacion,
                'responsable' => $value->responsable,
                'fecha_mantenimiento' => $value->fecha_mantenimiento,
                'estado' => $value->estado,
                'id_mantenimiento' => $value->id_mantenimiento,
                'rol' => $self_rol,
            ]);
        }

        return $mantenimientos;
    }
    public function viewMantenices()
    {
        $datos = ModelMantenimientos::getMaquinas();
        $responsables = ModelUsuarios::ObtenerTodosLosUsuarios();
        $self_rol = Auth::user()->rol_user;
        $self_nombre = Auth::user()->nombre;
        $fechas = $this->hoy;

        $data = [];
        foreach ($datos as $key) {

            array_push($data, [

                'referencia' => $key->referencia,
                'nombre_maquina' => $key->nombre_maquina,
                'id_maquina' => $key->id_maquina
            ]);
        }

        ($self_rol == '1') ? $get_Mantenices = self::getAllMantenices() : $get_Mantenices  = self::getManteniceLess2days();

        return
            view('apps.intranet_fabrica.fabrica.hojas_vida.mantenimiento',
                ['data' => $data, 'responsables' => $responsables, 'mantenimientos' => $get_Mantenices, 'hoy' => $fechas, 'rol' => $self_rol, 'user' => $self_nombre]
            );
    }


    public function saveMantenices(Request $request)
    {
        $render = self::saveMantenice($request);
        if ($render) {

            return response()->json(['status' => true, 'render' => $render], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }


    public function saveMantenice($request)
    {

        $id_maquina = $request->select;
        $responsable = $request->responsable;
        $fecha = $request->calendar;
        $observacion = $request->observacion;
        $errores = $request->errores;
        $nombre = Auth::user()->nombre;
        $nameAndReference = ModelMantenimientos::getReferenceAndName($id_maquina);
        $data = [];
        $responsable2 = ModelUsuarios::getInfoUser($responsable);
        $fecha_hoy = self::validarFecha($fecha);
        $hoy = date('Y-m-d');
        $hoja_vida = $request->hoja_vida;


        if ($errores >= 5 && $fecha_hoy) {
            foreach ($responsable2 as $value) {

                $responsable3 = $value->nombre;
            }

            foreach ($nameAndReference as $value) {

                array_push($data, [

                    'nombre_maquina' => $value->nombre_maquina,
                    'referencia' => $value->referencia,
                    "id_maquina" => $id_maquina,
                    'id_user' => $responsable,
                    'responsable' => $responsable3,
                    'fecha_mantenimiento' => $fecha,
                    'observacion' => $observacion,
                    'estado'  => 'programado',
                    'hoja_vida' => $hoja_vida,
                    'nombre_creador' => $nombre,
                    'fecha_creacion' => $hoy
                ]);
            }


            $insert = ModelMantenimientos::insertMantenice($data);
            if ($insert) {
                $hoy = $this->hoy;
                $rol_user = Auth::user()->rol_user;
                $data_html = ModelMantenimientos::getAllMantenices();
                $datos = [];
                foreach ($data_html as $value) {

                    array_push($datos, [

                        'id_mantenimiento' => $value->id_mantenimiento,
                        'id_maquina' => $value->id_maquina,
                        'id_user' => $value->id_user,
                        'referencia' => $value->referencia,
                        'nombre_maquina' => $value->nombre_maquina,
                        'observacion' => $value->observacion,
                        'estado' => $value->estado,
                        'hoja_vida' => $value->hoja_vida,
                        'fecha_mantenimiento' => $value->fecha_mantenimiento,
                        'responsable' => $value->responsable

                    ]);
                }
                return view('apps.intranet_fabrica.fabrica.hojas_vida.tabla_mantenice', ['mantenimientos' => $datos, 'hoy' => $hoy, "rol" => $rol_user])->render();
            }
        }
    }



    public function chargeMantenices(Request $request)
    {

        $id_mantenimiento = $request->id_mantenimiento;
        $mantenimiento = ModelMantenimientos::getIdMantenice($id_mantenimiento);

        if ($mantenimiento) {

            $data = [];

            foreach ($mantenimiento as $value) {

                array_push($data, [

                    'referencia' => $value->referencia,
                    'responsable' => $value->nombre_creador,
                    'observacion' => $value->observacion,
                    'fecha_mantenimiento' => $value->fecha_mantenimiento,
                    'maquina' => $value->nombre_maquina,
                    'id_user' => $value->id_user,
                    'id_mantenimiento' => $value->id_mantenimiento
                ]);
            }
            return response()->json(['status' => true, 'mantenice' => $data], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }


    public function changeMantenices(Request $request)
    {

        $id_user = $request->responsable1;
        $calendario = $request->calendar1;
        $observacion = $request->observacion1;
        $id_mantenimiento = $request->id_mantenimiento;

        $nombre_responsable = ModelUsuarios::getNameUser($id_user);

        foreach ($nombre_responsable as $value) {

            $nombre = $value->nombre;
        }

        $data = [

            'id_user' => $id_user,
            'fecha_mantenimiento' => $calendario,
            'observacion' => $observacion,
            'responsable' => $nombre
        ];

        $insert = ModelMantenimientos::changeMantenice($id_mantenimiento, $data);

        if ($insert) {
            $tabla = self::getViewTable();

            return response()->json(['render' => $tabla]);
        }
    }

    public function getViewTable()
    {

        $get_all_mantenice = ModelMantenimientos::getAllMantenices();
        $datos = [];
        $rol_user = Auth::user()->rol_user;

        foreach ($get_all_mantenice as $value) {


            array_push($datos, [

                'id_mantenimiento' => $value->id_mantenimiento,
                'id_maquina' => $value->id_maquina,
                'id_user' => $value->id_user,
                'referencia' => $value->referencia,
                'nombre_maquina' => $value->nombre_maquina,
                'observacion' => $value->observacion,
                'estado' => $value->estado,
                'hoja_vida' => $value->hoja_vida,
                'fecha_mantenimiento' => $value->fecha_mantenimiento,
                'responsable' => $value->responsable

            ]);
        }

        $hoy = $this->hoy;
        return view('apps.intranet_fabrica.fabrica.hojas_vida.tabla_mantenice', ['mantenimientos' => $datos, 'hoy' => $hoy, 'rol' => $rol_user])->render();
    }


    public function deleteMantenices(Request $request)
    {

        $id_borrar = $request->id_mantenimiento;
        $borrar = ModelMantenimientos::deleteMantenices($id_borrar);

        if ($borrar) {

            $tabla = self::getViewTable();

            return response()->json(['render' => $tabla]);
        }
    }


    public function getMantenicesUser()
    {
        $get_mantenices_programados = ModelMantenimientos::getMantenicesUser();
        $mantenimientos = [];

        foreach ($get_mantenices_programados as $value) {

            $mantenimientos = [];
            array_push($mantenimientos, [

                'referencia' => $value->referencia,
                'nombre_maquina' => $value->nombre_maquina,
                'observacion' => $value->observacion,
                'responsable' => $value->nombre_creador,
                'fecha_mantenimiento' => $value->fecha_mantenimiento,
                'estado' => $value->estado,
                'id_mantenimiento' => $value->id_mantenimiento
            ]);
        }

        return $mantenimientos;
    }

    public function validarDiaLab($fecha_prog)
    {

        $fecha_i = $fecha_prog;
        $fecha_ = date("Y-m-d", strtotime($fecha_prog . "+ 1 days"));
        $fecha_prox_fes = ModelMantenimientos::getfechaProxima($fecha_);

        $fecha2 = new DateTime($fecha_prox_fes);
        $fecha1 = new DateTime($fecha_i);

        $dias = $fecha1->diff($fecha2);
        $dias_ = $dias->d;

        if ($dias_ == 1) {
            self::validarDiaLab($fecha_);
        }

        return $fecha_i;
    }

    public function getManteniceLess2days()
    {
        $id_user = Auth::user()->id;

        $no_dias = ModelMantenimientos::getDiasNoLaborales();
        $hoy1 = $this->hoy;

        $fechas_no_laborales = [];

        for ($i = 0; $i < count($no_dias); $i++) {

            $fechas_no_laborales[$i] = $no_dias[$i]->fecha;
        }

        $fecha_max = date("Y-m-d", strtotime($hoy1  . "+ 5 days"));
        $fecha_min = date("Y-m-d", strtotime($hoy1));

        $fecha_inicial = self::validacionDate($fecha_min);
        $consulta = ModelMantenimientos::getMantenicesUsers($id_user, $fecha_inicial, $fecha_max);

        foreach ($consulta as  $value) {
            $fecha_prog = $value->fecha_mantenimiento;
            self::validarDiaLab($fecha_prog);
        }
        $data = [];

        foreach ($consulta as $value) {

            $fecha_m = $value->fecha_mantenimiento;
            $hoy = new DateTime($hoy1);
            $suma_fecha = date("Y-m-d", strtotime($fecha_m . "+ 2 days"));

            if (in_array($suma_fecha, $fechas_no_laborales)) {

                $fecha_out = false;
                while (!$fecha_out) {
                    $suma_fecha =  date("Y-m-d", strtotime($suma_fecha . "+ 1 days"));

                    if (in_array($suma_fecha, $fechas_no_laborales)) {
                        $fecha_out = false;
                    } else {
                        $fecha_out = true;
                    }
                }
            }

            $diff_dias = new DateTime($suma_fecha);
            $diferencia = $diff_dias->diff($hoy)->d;

            array_push($data, [
                'referencia' => $value->referencia,
                'nombre_maquina' => $value->nombre_maquina,
                'observacion' => $value->observacion,
                'responsable' => $value->nombre_creador,
                'fecha_mantenimiento' => $value->fecha_mantenimiento,
                'estado' => $value->estado,
                'id_mantenimiento' => $value->id_mantenimiento,
                'extemporaneo' => $suma_fecha,
                'diferencia' => $diferencia
            ]);
        }
        return $data;
    }


    public function cargarMantenimiento(Request $request)
    {
        $id_mantenimiento = $request->mantenimiento;
        $consulta = ModelMantenimientos::getMantenimientoId($id_mantenimiento);
        $data = [
            'fecha_mantenimiento' => $consulta->fecha_mantenimiento,
            'responsable' => $consulta->nombre_creador,
            'id_mantenimiento' => $consulta->id_mantenimiento,
            'referencia' => $consulta->referencia,
            'maquina' => $consulta->nombre_maquina
        ];

        if ($consulta) {


            return response()->json(['info' => $data], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }


    public function requestMantenimiento(Request $request)
    {


        $mantenimiento = $request->mantenimiento;
        $observacion = $request->observacion;
        $hoy = date('Y-m-d');



        $insercion = ModelMantenimientos::requestMantenimiento($mantenimiento, $observacion, $hoy);


        if ($insercion) {
            $tabla = self::viewTableUser();

            return response()->json(["status" => true, 'tabla' => $tabla]);
        }
    }


    public function viewTableUser()
    {
        $rol_user = Auth::user()->rol_user;
        $get_all_mantenice = self::getManteniceLess2days();


        $hoy = $this->hoy;

        return view('apps.intranet_fabrica.fabrica.hojas_vida.tabla_mantenice', ['mantenimientos' => $get_all_mantenice, 'hoy' => $hoy, 'rol' => $rol_user])->render();
    }


    public function showMantenice($request)
    {


        $referencia = $request->referencia;

        $referencia2 = trim($referencia);
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;

        if (isset($fecha_i) && isset($fecha_f)) {

            $consulta = ModelMantenimientos::getMantenicesDates($referencia2, $fecha_i, $fecha_f);




            if ($consulta) {

                return view('apps.intranet_fabrica.fabrica.hojas_vida.show_mantenices', ['data' => $consulta])->render();
            }
        } else {

            $consulta_toda = ModelMantenimientos::showMantenice($referencia2);

            return view('apps.intranet_fabrica.fabrica.hojas_vida.show_mantenices', ['data' => $consulta_toda])->render();
        }
    }


    public function showMantenices(Request $request)
    {
        $consulta  = self::showMantenice($request);
        if ($consulta) {
            return response()->json(['contenido' => $consulta]);
        }
    }

    public function showNoHistory()
    {

        $consulta = ModelMantenimientos::showNoHistory();

        return view('apps.intranet_fabrica.fabrica.hojas_vida.historiales_hdv', ['data' => $consulta]);
    }


    public function dateMaxJob($fecha_hoy)
    {

        $consulta = ModelMantenimientos::getDaysNoJob($fecha_hoy);
    }


    public function searcher(Request $request)
    {

        $vista_render = self::searchers($request);

        if ($vista_render) {


            return response()->json(['render' => $vista_render]);
        }
    }

    public function searchers($request)
    {

        $buscar = $request->buscar;

        if (isset($buscar)) {

            $consulta = ModelMantenimientos::searcher($buscar);
        } else {

            $consulta = ModelMantenimientos::showNoHistory();
        }

        if ($consulta) {


            return view('apps.intranet_fabrica.fabrica.hojas_vida.no_hdv_table', ['data' => $consulta])->render();
        }
    }


    public function searcherDate(Request $request)
    {

        $consulta = self::searcherDates($request);


        if ($consulta) {


            return response()->json(['render' => $consulta]);
        }
    }

    public function searcherDates($request)
    {


        $rango1 = $request->fecha1;
        $rango2 = $request->fecha2;

        $consulta = ModelMantenimientos::searcherDate($rango1, $rango2);

        if ($consulta) {

            return view('apps.intranet_fabrica.fabrica.hojas_vida.no_hdv_table', ['data' => $consulta])->render();
        }
    }

    public function validacionDate($hoyLess2)
    {

        $fecha = $hoyLess2;
        $aux = 0;


        do {

            $n_fecha = date("Y-m-d", strtotime($fecha  . "- 1 days"));
            $validar = ModelMantenimientos::getDaysNoJob($n_fecha);
            $fecha = $n_fecha;
            if ($validar ==  0) {

                $aux = $aux + 1;
            }

            if ($aux == 2) {

                $validar = 0;
            } else {
                $validar++;
            }
        } while ($validar != 0);
        return $fecha;
    }
}
