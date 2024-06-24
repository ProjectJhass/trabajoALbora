<?php

namespace App\Models\apps\intranet_fabrica;

use App\Models\apps\intranet_fabrica\orm\ModelAnexosPQRS;
use App\Models\apps\intranet_fabrica\orm\ModelRespuestaPQRS;
use App\Models\apps\intranet_fabrica\orm\ModelSolicitudesPQRS;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ModelPQRSFabrica extends Model
{
    public static function getTodos()
    {

        $data = ModelSolicitudesPQRS::select()
            ->orderByDesc('id')
            ->get();
        $data_info = [];
        foreach ($data as $index => $value) {
            $id = $value->id;
            if (!isset($data_info[$id])) {
                $data_info[$id] = [];
            }
            if ($value->tipo_solicitud == 'PETICIÃƒâ€œN') {
                $value->tipo_solicitud = 'Peticion';
            }
            $data_info[$id][] = [
                'id' => $index + 1,
                'consecutivo' => $value->id,
                'estado' => $value->estado,
                'nombres' => $value->nombres,
                'apellidos' => $value->apellidos,
                'tipo_solicitud' => $value->tipo_solicitud,
            ];
        }
        return $data_info;
    }

    public static function getPendientes()
    {
        $data = ModelSolicitudesPQRS::select()
            ->where('estado', '=', 'Pendiente')
            ->orderByDesc('id')
            ->get();
        $data_info = [];
        foreach ($data as $index => $value) {
            $id = $value->id;
            if (!isset($data_info[$id])) {
                $data_info[$id] = [];
            }
            if ($value->tipo_solicitud == 'PETICIÃƒâ€œN') {
                $value->tipo_solicitud = 'Peticion';
            }
            $data_info[$id][] = [
                'id' => $index + 1,
                'consecutivo' => $value->id,
                'estado' => $value->estado,
                'nombres' => $value->nombres,
                'apellidos' => $value->apellidos,
                'tipo_solicitud' => $value->tipo_solicitud,
            ];
        }
        return $data_info;
    }
    public static function getRealizados()
    {
        return ModelSolicitudesPQRS::with('infoRespuestas')
            ->where('estado', '=', 'Realizado')
            ->orderByDesc('id')
            ->get();
    }
    public static function createNueva($nombres, $apellidos, $cargo, $email, $tipo_solicitud, $lugar, $descripcion)
    {
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $data = ([
            'fecha' => $fecha,
            'hora' => $hora,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'cargo' => $cargo,
            'email' => $email,
            'tipo_solicitud' => $tipo_solicitud,
            'lugar' => $lugar,
            'descripcion' => $descripcion,
            'estado' => "Pendiente",
        ]);

        $id = ModelSolicitudesPQRS::insertGetId($data);

        $dataEmail = [
            'numero_registro' => $id,
            'fecha_registro' => $fecha,
            'tipo_pqrs' => $tipo_solicitud,
            'origen' => $lugar
        ];

        return $dataEmail;
    }

    public static function addAnexos($payload)
    {
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $data = [];
        foreach ($payload as $anexo) {
            $data[] = ([
                'consecutivo' => $anexo[0],
                'nombre' => $anexo[1],
                'extension' => $anexo[2],
                'peso' => $anexo[3],
                'fecha' => $fecha,
                'hora' => $hora,
            ]);
        }

        ModelAnexosPQRS::insert($data);
    }

    public static function responderSolicitud($id, $respuesta)
    {
        $fecha = date('Y-m-d');
        $hora = date('H:s:i');
        $responsable =  Auth::user()->nombre;
        $data = ([
            'consecutivo' => $id,
            'fecha' => $fecha,
            'hora' => $hora,
            'responsable' => $responsable,
            'respuesta' => $respuesta
        ]);

        $id_respuesta = ModelRespuestaPQRS::insertGetId($data);
        return ModelSolicitudesPQRS::with('infoRespuestas')
        ->where('id', '=', $id)
        ->first();
    }
}
