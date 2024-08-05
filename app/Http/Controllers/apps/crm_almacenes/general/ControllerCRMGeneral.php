<?php

namespace App\Http\Controllers\apps\crm_almacenes\general;

use App\Http\Controllers\Controller;
use App\Models\apps\crm_almacenes\ModelClientesCRM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerCRMGeneral extends Controller
{
    public function getClientBirthdayAdviser()
    {
        $asesor_ = Auth::user()->id;
        $date_d = date('d');
        $date_m = date('m');

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

        return response()->json(['status' => true, 'viewBirtdayClient' => $view_construct_birthday, 'data_birthday' => $birthday, 'count_birthday' => count($birthday)], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
