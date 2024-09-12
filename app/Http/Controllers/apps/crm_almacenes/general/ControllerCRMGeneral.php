<?php

namespace App\Http\Controllers\apps\crm_almacenes\general;

use App\Http\Controllers\Controller;
use App\Models\apps\crm_almacenes\ModelClientesCRM;
use App\Models\apps\crm_almacenes\ModelCumpleClientesCRM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerCRMGeneral extends Controller
{
    public function getClientBirthdayAdviser()
    {
        $asesor_ = Auth::user()->id;
        $date_d = date('d');
        $date_m = date('m');

        if(Auth::user()->cargo == "administrador") {

            $date_d_tomorrow = date("d", strtotime("+1 day"));

            $birthday =  ModelClientesCRM::whereDay('fecha_cumple', $date_d)
                ->leftJoin('cumple_enviados_cliente', 'cumple_enviados_cliente.id_cliente', '=', 'clientes_crm.id_cliente')
                ->join('users', 'users.id', '=', 'clientes_crm.cedula_asesor')
                ->whereMonth('fecha_cumple', $date_m)
                ->get();

            $birthday_tomorrow = ModelClientesCRM::whereDay('fecha_cumple', $date_d_tomorrow)
                ->whereMonth('fecha_cumple', $date_m)
                ->get();

            $view_construct_birthday = view(
                'apps.crm_almacenes.general.birthday_body',
                [
                    'data_birthday' => $birthday,
                    'count_birthday' => count($birthday),
                    'data_birthday_tomorrow' => $birthday_tomorrow,
                    'count_birthday_tomorrow' => count($birthday_tomorrow),
                    'date_d_tomorrow' => $date_d_tomorrow
                ]
            )->render();

        } else{

            $date_d_tomorrow = date("d", strtotime("+1 day"));

            $birthday =  ModelClientesCRM::whereDay('fecha_cumple', $date_d)
                ->whereMonth('fecha_cumple', $date_m)
                ->where('cedula_asesor', $asesor_)
                ->get();

            $birthday_tomorrow = ModelClientesCRM::whereDay('fecha_cumple', $date_d_tomorrow)
                ->whereMonth('fecha_cumple', $date_m)
                ->where('cedula_asesor', Auth::user()->id)
                ->get();

            $view_construct_birthday = view(
                'apps.crm_almacenes.general.birthday_body',
                [
                    'data_birthday' => $birthday,
                    'count_birthday' => count($birthday),
                    'data_birthday_tomorrow' => $birthday_tomorrow,
                    'count_birthday_tomorrow' => count($birthday_tomorrow),
                    'date_d_tomorrow' => $date_d_tomorrow
                ]
            )->render();
        }


        return response()->json(['status' => true, 'viewBirtdayClient' => $view_construct_birthday, 'data_birthday' => $birthday, 'count_birthday' => count($birthday)], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function postClientBirthdayAdviser(Request $request) {
        $asesor_ = Auth::user()->id;
        $id_client = $request->id_client;
        $cell_client = $request->cell_client;
        $text_client = base64_encode($request->text_client);
        $img_client = $request->img_client;

        $verify_register_client_cumple = ModelCumpleClientesCRM::where('id_cliente', $id_client)->where('id_asesor', $asesor_)->get();

        if(count($verify_register_client_cumple) > 0) {
            ModelCumpleClientesCRM::where('id_cliente', $id_client)->where('id_asesor', $asesor_)->update([
                'cell_enviado' => $cell_client,
                'text_enviado' => $text_client,
                'img_url' => $img_client,
            ]);

            return response()->json(["status" => true, "message" => "Se actualizo satisfactoriamente los datos del cumpleaños del cliente"], 200);

        } else {

            ModelCumpleClientesCRM::create([
                "id_cliente" => $id_client,
                "id_asesor" => $asesor_,
                "cell_enviado" => $cell_client,
                "text_enviado" => $text_client,
                "img_url" => $img_client
            ]);

            return response()->json(["status" => true, "mesasge" => "Se creo satisfactoriamente los datos del cumpleaños del cliente"], 200);

        }


    }

}
