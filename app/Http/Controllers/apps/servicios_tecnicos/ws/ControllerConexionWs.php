<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\ws;

use App\Http\Controllers\Controller;
use App\Models\soap\st_ModelConsultas;
use Illuminate\Http\Request;

class ControllerConexionWs extends Controller
{
    public function getInfoFacturasCliente(Request $request)
    {

        $cedula = $request->cedula;
        $almacen = $request->almacen;

        $check = '';

        $data = st_ModelConsultas::facturasClientes($cedula, $almacen);

        if (count($data) == 0) {
            return response()->json(['data' => 'No hay facturas registradas para esta cédula'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }

        foreach ($data as $key => $value) { //checkbox - radio

            $num_fac = str_repeat("0", (8 - strlen($value['num_fac']))) . $value['num_fac'];
            $num_rem = str_repeat("0", (8 - strlen($value['num_rem']))) . $value['num_rem'];
            $remision = $value['rem'] . '-' . $num_rem;

            $check .= '
                <div class="form-check">
                    <input class="form-check-input" type="radio" data-factura="' . $value['factura'] . '-' . $num_fac . '" data-fecha_fac="' . date('Y-m-d', strtotime($value['fecha_fac'])) . '" data-rem="' . $remision . '" data-fecha_rem="' . date('Y-m-d', strtotime($value['fecha_rem']))  . '" value="' . $value['id'] . '" name="factura_cliente" id="factura' . $value['id'] . '" />
                    <label class="form-check-label" for="factura' . $value['id'] . '"> ' . $value['factura'] . '-' . $num_fac . '</label>
                </div>
            ';
        }

        return response()->json(['data' => $check], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function getInfoProductosCliente(Request $request)
    {
        $rowid = $request->id_factura;
        $data = st_ModelConsultas::productosClientes($rowid);

        $check = '';

        if (count($data) == 0) {
            return response()->json(['data' => 'No hay productos para esta factura'], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
        }

        foreach ($data as $key => $value) { //checkbox - radio

            $ext1 = isset($value['ext1']) ? $value['ext1'] : "";
            $ext2 = isset($value['ext2']) ? $value['ext2'] : "";

            $check .= '
                <div class="form-check">
                    <input class="form-check-input" type="radio" data-ext1 ="' . $ext1 . '" data-ext2 ="' . $ext2 . '" data-id_item="' . $value['id'] . '" value="' . base64_encode($value['producto']) . '" name="item_cliente" id="item' . $value['id'] . '" />
                    <label class="form-check-label" for="item' . $value['id'] . '"> ' . $value['producto'] . '</label>
                </div>
            ';
        }

        return response()->json(['data' => $check], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
