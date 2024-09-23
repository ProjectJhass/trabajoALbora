<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INSPECCION_DE_MATERIA_PRIMA_BLOQUES_{{ $id_materia_prima }}</title>
    <link href="{{ asset('plugins/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
</head>

<!-- width: 100%; border: .5px solid; border-radius: 20px; -->

<body>

    @php
        // $m_ = $control->id_madera == 1 ? 3 : 2;
        $m_ = 3;
    @endphp

    <div style="margin: 1%">
        <table style="width: 100%">
            <thead>
                <tr>
                    <th style="width: 50%"><img src="{{ asset('img/img_log_rojo.png') }}" alt="" width="80%">
                    </th>
                    <th style="width: 50%; text-align: center">
                        <h4>INSPECCIÓN DE MATERIA PRIMA MADERA {{ strtoupper($control->madera) }}</h4>
                    </th>
                </tr>
            </thead>
        </table><br><br>
        <table style="width: 100%">
            <thead class="text-center">
                <tr>
                    <th style="width: 33.3%">CÓDIGO: RG-CPS-12</th>
                    <th style="width: 33.3%">VERSIÓN: 001</th>
                    <th style="width: 33.3%">PÁGINA: 01</th>
                </tr>
            </thead>
        </table><br><br>
        <table style="width: 99%">
            <tbody>
                <tr style="width: 100%">
                    <td style="width: 5%">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">FECHA</span>
                            </div>
                            <input type="text" class="form-control" readonly value="{{ $control->created_at }}">
                        </div>
                    </td>
                    <td style="width: 50%;">
                        <div class="input-group mb-3 ml-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">SUBPROCESO</span>
                            </div>
                            <input type="text" class="form-control" readonly value="{{ $control->subproceso }}">
                        </div>
                    </td>
                </tr>
                <tr style="width: 100%">
                    <td style="width: 50%">
                        <div class="input-group mb-3 mr-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">TIPO DE VEHÍCULO</span>
                            </div>
                            <input type="text" class="form-control" readonly value="{{ $control->tipo_vehiculo }}">
                        </div>
                    </td>
                    <td style="width: 50%">
                        <div class="input-group mb-3 ml-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">PLACA</span>
                            </div>
                            <input type="text" class="form-control" readonly value="{{ $control->placa }}">
                        </div>
                    </td>
                </tr>
                <tr style="width: 100%">
                    <td style="width: 50%">
                        <div class="input-group mb-3 mr-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">SALVO CONDUCTO</span>
                            </div>
                            <input type="text" class="form-control" readonly value="{{ $control->conducto }}">
                        </div>
                    </td>
                    <td style="width: 50%">
                        <div class="input-group mb-3 ml-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">CANTIDAD DE BLOQUES</span>
                            </div>
                            <input type="text" class="form-control" readonly value="{{ $madera_total_null }}">
                        </div>
                    </td>
                </tr>
                <tr style="width: 100%">
                    <td style="width: 50%">
                        <div class="input-group mb-3 mr-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">CANTIDAD DE PULGADAS</span>
                            </div>
                            <input type="text" class="form-control" readonly value="{{ round($total_pulgadas) }}">
                        </div>
                    </td>
                    <td style="width: 50%">
                        <div class="input-group mb-3 ml-3 mr-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">PORCENTAJE POR DEBAJO DE
                                    {{ $m_ }} m</span>
                            </div>
                            <input type="text" class="form-control" readonly
                                value="{{ round($porcentaje_por_debajo_de_3) }} %">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table style="width: 99%">
            <tbody>
                <tr style="width: 100%">
                    <td style="width: 50%">
                        <div class="input-group mb-3 mr-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">CANTIDAD DE BLOQUES CASTIGADOS</span>
                            </div>
                            <input type="text" class="form-control" readonly value="{{ round($cantidad_bloques_castigados) }}">
                        </div>
                    </td>
                    <td style="width: 50%">
                        <div class="input-group mb-3 ml-3 mr-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">PORCENTAJE DE BLOQUES CASTIGADOS
                                    {{ $m_ }} m</span>
                            </div>
                            <input type="text" class="form-control" readonly
                                value="{{ round($porcentaje_bloques_castigados) }} %">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="3" class="text-center" style="vertical-align: middle">CONSECUTIVO</th>
                    <th colspan="5" class="text-center">PUNTA</th>
                </tr>
                <tr>
                    <th colspan="4" class="text-center">MEDIDAS</th>
                    <th rowspan="3" class="text-center" style="vertical-align: middle"> CANTIDAD PULGADA</th>
                </tr>
                <tr>
                    <th class="text-center">¿CASTIGADO?</th>
                    <th class="text-center">ANCHO</th>
                    <th class="text-center">GRUESO</th>
                    <th class="text-center">LARGO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($madera as $item)
                    <tr>
                        <td class="text-center">{{ $item->id }}</td>
                        <td class="text-center">{{ $item->bloque_castigado ? 'X' : '' }}</td>
                        <td class="text-center">{{ $item->ancho }}</td>
                        <td class="text-center">{{ $item->grueso }}</td>
                        <td class="text-center">{{ $item->largo }}</td>
                        <td class="text-center">{{ number_format($item->pulgadas) }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</body>
<footer>

</footer>

</html>
