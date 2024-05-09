<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\servicios\pw;

use App\Http\Controllers\Controller;
use App\Models\apps\servicios_tecnicos\pagina_web\ModelEvidenciasPw;
use App\Models\apps\servicios_tecnicos\pagina_web\ModelPaginaWeb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ControllerAdminInfoPw extends Controller
{
    public function getTable($data)
    {
        return view('apps.servicios_tecnicos.servicios_tecnicos.apps.servicios_tecnicos.pagina_web.table', ['ost' => $data])->render();
    }

    public function infoPaginaWeb()
    {
        $data = ModelPaginaWeb::where('estado', 'creado')->orderBy('created_at', 'desc')->get();
        $table = self::getTable($data);
        return view('apps.servicios_tecnicos.servicios_tecnicos.apps.servicios_tecnicos.pagina_web.solicitudes', ['table' => $table]);
    }

    public function searchInfo(Request $request)
    {
        $extensions = (['png', 'jpg', 'jpeg', 'tiff', 'webp']);
        $extensions2 = (['mp4']);

        $data = ModelPaginaWeb::find($request->id);
        $id_st_wb = $data->id_ost;

        $fotos = '';
        $videos = '';

        $evidencias = ModelEvidenciasPw::where('id_ost_FK', $id_st_wb)->get();
        foreach ($evidencias as $key => $value) {
            if (in_array($value->extension, $extensions)) {
                $fotos .= '<div class="col-md-3">
                <a href="' . asset('storage/EvidenciasOST/' . $value->nombre_doc) . '" target="_BLANK">
                    <img src="' . asset('storage/EvidenciasOST/' . $value->nombre_doc) . '" width="100%" alt="">
                </a>
            </div>';
            } else {
                if (in_array($value->extension, $extensions2)) {
                    $videos .= '<div class="col-md-3">
                                    <video src="' . asset('storage/EvidenciasOST/' . $value->nombre_doc) . '" controls></video>
                                </div>';
                }
            }
        }

        return response()->json(['data' => $data, 'img' => $fotos, 'vid' => $videos], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function deleteSolicitudPw(Request $request)
    {
        $id = $request->id;
        $modelPaginaWeb = ModelPaginaWeb::find($id);

        if ($modelPaginaWeb) {
            $modelPaginaWeb->delete();

            $img_pw = ModelEvidenciasPw::where('id_ost_FK', $id)->get();
            foreach ($img_pw as $key => $value) {
                $name = str_replace("/storage/", "", $value->url);
                if (Storage::exists("public/" . $name)) {
                    Storage::delete("public/" . $name);
                    $img_pw_db = ModelEvidenciasPw::find($value['id_evidencia']);
                    $img_pw_db->delete();
                }
            }

            $data = ModelPaginaWeb::where('estado', 'creado')->orderBy('created_at', 'desc')->get();
            $table = self::getTable($data);

            return response()->json(['status' => true, 'table' => $table], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        } else {
            return response()->json([], 401, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }
    }
}
