<?php

namespace App\Http\Controllers\apps\intranet_fabrica;

use App\Http\Controllers\Controller;
use App\Models\apps\intranet_fabrica\ModelComentariosHojasDeVida;
use App\Models\apps\intranet_fabrica\ModelHojaDeVida;
use App\Models\apps\intranet_fabrica\ModelMantenimientos;
use App\Models\apps\intranet_fabrica\orm\ModelHvMaquinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ControllerHojasDeVida extends Controller
{
    public function maquinas($collection)
    {
        return view('apps.intranet_fabrica.fabrica.hojas_vida.busqueda.maquinas', ['maquinas' => $collection])->render();
    }

    // se mustras las maquinas existentes
    public function hojasDeVida()
    {
        $info = ModelHvMaquinas::limit(12)->get();
        $maquinas = self::maquinas($info);
        return view('apps.intranet_fabrica.fabrica.hojas_vida.hoja_de_vida', ['maquinas' => $maquinas]);
    }


    public function buscarMaquinaHojaDeVida(Request $request)
    {
        $valor = $request->valor;
        if (empty($valor)) {
            $info = ModelHvMaquinas::limit(12)->get();
        } else {
            $info = ModelHvMaquinas::where("referencia", "LIKE", "%$valor%")->orWhere("nombre_maquina", "LIKE", "%$valor%")->get();
        }
        $maquinas = self::maquinas($info);
        return response()->json(['status' => true, 'maquinas' => $maquinas], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }


    // se obtiene todo el historial de una maquina
    public function historialMaquina($referencia)
    {
        $maquina = trim($referencia);
        $historialMaquina = ModelHojaDeVida::ObtenerhistorialMaquina($maquina);
        $comentarios = ModelComentariosHojasDeVida::obtenerComentarios($maquina);
        $carga = ModelMantenimientos::showMantenice($maquina);
        return view('apps.intranet_fabrica.fabrica.hojas_vida.historial_maquina', ['referencia' => $maquina, 'datos' => $carga, 'historialMaquina' => $historialMaquina, 'comentarios' => $comentarios]);
    }


    // se actualiza o cambiar la imagen de una maquina
    public function actualizarImagenMaquina(Request $request)
    {
        $request->validate([
            'idMaquina' => 'required|string',
            'imgMaquina' => 'required|file|mimes:jpeg,png,jpg,gif',
        ]);
        $idMaquina = $request->idMaquina;
        $nombreImagen = $request->file('imgMaquina')->getClientOriginalName();
        $ruta = 'img/imgMaquinas/' . $nombreImagen;
        File::move($request->file('imgMaquina')->path(), $ruta);

        $actualizarImg = ModelHojaDeVida::actualizarImagenMaquina($idMaquina, $nombreImagen);
        if ($actualizarImg) {
            return response()->json(['mensaje' => 'Se actualizo correctamente', 'rutaImg' => $ruta], 200);
        } else {
            return response()->json(['mensaje' => 'Ocurrio un error'], 500);
        }
    }

    // guardar los comentarios que se realizan al historial de una maquina
    public function GuardarComentario(Request $request)
    {
        $data = [
            'referencia_maquina' => $request->id_maquina,
            'comentario' => $request->comentario,
            'usuario' => Auth::user()->id,
            'fecha' => date('Y-m-d')
        ];

        $crarComentario = ModelComentariosHojasDeVida::crearComentario($data);
        if ($crarComentario) {
            return response()->json(['comentario' => $request->comentario], 200);
        } else {
            return response()->json(['mensaje' => 'Ocurrio un error'], 500);
        }
    }


    // se obtiene todo el historial de una maquina en un rango de fechas
    public function historialFechas(Request $request)
    {
        $referenciaMaquina = $request->referencia;
        $fechaInicial = date('Y-m-d', strtotime($request->fechaInicial));
        $fechaFinal = date('Y-m-d', strtotime($request->fechaFinal));
        $historialMaquina = ModelHojaDeVida::ObtenerhistorialPorFecha($referenciaMaquina, $fechaInicial, $fechaFinal);

        if ($historialMaquina) {
            if (count($historialMaquina) != 0) {
                $procedimientos = view('apps.intranet_fabrica.fabrica.hojas_vida.cargar_procedimientos_realizados', ['referencia' => $referenciaMaquina, 'historialMaquina' => $historialMaquina])->render();
                return response()->json(['historialMaquina' => $procedimientos], 200);
            } else {
                return response()->json(['mensaje' => 'No se encontraron resultados'], 500);
            }
        } else {
            return response()->json(['mensaje' => 'Ocurrió un error en el proceso'], 500);
        }
    }
}
