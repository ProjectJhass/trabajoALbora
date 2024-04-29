<?php

namespace App\Http\Controllers\apps\servicios_tecnicos\servicios;

use App\Http\Controllers\Controller;
use App\Models\apps\servicios_tecnicos\pagina_web\ModelPaginaWeb;
use App\Models\apps\servicios_tecnicos\servicios\infoAlmacenes;
use App\Models\apps\servicios_tecnicos\servicios\ModelCausalidades;
use App\Models\soap\st_ModelConsultas;
use Illuminate\Http\Request;

class ControllerCreateServicio extends Controller
{
    protected function estructuraForm($data_cl, $articulo, $factura, $fecha_factura, $remision, $fecha_rem, $id_item, $ext1, $ext2)
    {
        if (count($data_cl) > 0) {
            $array = [];

            foreach ($data_cl as $key => $value) {

                $pago = (trim($value['forma_pago']) == 'CON') ? 'CONTADO' : 'CREDITO';
                $celular = isset($value['celular2']) ? trim($value['celular']) . ' - ' . trim($value['celular2']) : (isset($value['celular']) ? trim($value['celular']) : '');

                $direccion = isset($value['direccion']) ? $value['direccion'] : '';
                $barrio = isset($value['barrio']) ? $value['barrio'] : '';

                array_push($array, ([
                    'cedula' => trim($value['cedula']),
                    'nombre' => trim(trim($value['nombre']) . ' ' . trim($value['ap1']) . ' ' . trim($value['ap2'])),
                    'celular' => $celular,
                    'correo' => strtolower(trim($value['email'])),
                    'direccion' => trim($direccion),
                    'barrio' => trim($barrio),
                    'ciudad' => strtoupper(trim($value['ciudad'])),
                    'pago' => $pago,
                ]));
            }

            if (!empty($array)) {
                $array[0]['id_item'] = $id_item;
                $array[0]['articulo'] = trim($articulo);
                $array[0]['ext1'] = $ext1;
                $array[0]['ext2'] = $ext2;
                $array[0]['factura'] = $factura;
                $array[0]['fecha_factura'] = date('Y-m-d', strtotime($fecha_factura));
                $array[0]['remision'] = $remision;
                $array[0]['fecha_remision'] = date('Y-m-d', strtotime($fecha_rem));
                $array[0]['obs'] = "";
                $array[0]['ticket'] = "";
            }


            return $array;
        } else {
            return ([
                'cedula' => '',
                'nombre' => '',
                'celular' => '',
                'correo' => '',
                'direccion' => '',
                'barrio' => '',
                'ciudad' => '',
                'pago' => '',
                'id_item' => '',
                'articulo' => '',
                'ext1' => '',
                'ext2' => '',
                'factura' => '',
                'fecha_factura' => '',
                'remision' => '',
                'fecha_remision' => '',
                'obs' => '',
                'ticket' => ''
            ]);
        }
    }

    public function formNewST($data, $co)
    {
        $co_exp = '';
        if (!empty($co)) {
            $info_ = infoAlmacenes::where('numero', $co)->where('estado', '1')->get();
            $info_a = $info_->first();
            $co_exp = $info_a->almacen;
        }
        $products = st_ModelConsultas::allProductosSiesa();
        $causalidades = ModelCausalidades::where('estado', '1')->get();
        return view('apps.servicios_tecnicos.servicios_tecnicos.nueva_solicitud.form_nueva_solicitud', ['info' => $data, 'causales' => $causalidades, 'co_exp' => $co_exp, 'products' => $products])->render();
    }

    public function home()
    {
        $data = self::estructuraForm([], '', '', '', '', '', '', '', '');
        $viewForm = self::formNewST($data, '');

        return view('apps.servicios_tecnicos.servicios_tecnicos.nueva_solicitud.home', ['form' => $viewForm]);
    }

    public function formParametros(Request $request)
    {
        $id_factura = $request->factura_cliente;
        $data_cliente = st_ModelConsultas::infoCliente($id_factura);

        $id_item = $request->id_item;
        $ext1 = ''; // isset($request->ext1) ? $request->ext1 : '';
        $ext2 = ''; // isset($request->ext2) ? $request->ext2 : '';

        $data = self::estructuraForm($data_cliente, $request->item_cliente, $request->factura, $request->fecha_factura, $request->remision, $request->fecha_remision, $id_item, $ext1, $ext2);

        if (isset($request->ticket) && !empty($request->ticket)) {
            $data_i = ModelPaginaWeb::where('n_ticket', $request->ticket)->get();
            $data_ = $data_i->first();

            $data[0]['obs'] = $data_->descripcion_servicio;
            $data[0]['ticket'] = $request->ticket;
        }

        $viewForm = self::formNewST($data[0], $request->co_new_ost);
        return view('apps.servicios_tecnicos.servicios_tecnicos.nueva_solicitud.home', ['form' => $viewForm]);
    }

    public function infoPagWeb(Request $request)
    {
        $ticket = $request->ticket;
        $data_i = ModelPaginaWeb::where('n_ticket', $ticket)->get();
        $data_ = $data_i->first();

        $data = self::estructuraForm([], '', '', '', '', '', '', '', '');

        $data['cedula'] = $data_->cedula_cliente;
        $data['nombre'] = $data_->nombre;
        $data['celular'] = $data_->telefono;
        $data['correo'] = $data_->email;
        $data['obs'] = $data_->descripcion_servicio;
        $data['ticket'] = $ticket;

        $viewForm = self::formNewST($data, $data_->almacen);
        return view('apps.servicios_tecnicos.servicios_tecnicos.nueva_solicitud.home', ['form' => $viewForm]);
    }
}
