@php
    $m_ = $control->id_madera == 1 ? 3 : 2;
@endphp

<div style="margin: 1%">
    <table style="width: 99%">
        <tbody>
            <tr style="width: 100%">
                <td style="width: 5%">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">MADERA</span>
                        </div>
                        <input type="text" class="form-control" readonly value="{{ $control->madera }}">
                    </div>
                </td>
            </tr>
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
                        <input type="text" class="form-control" id="subproceso{{ $control->id }}" onkeyup="this.value=this.value.toUpperCase()"
                            onchange="editInfoHistory('1', '{{ $control->id }}')" value="{{ $control->subproceso }}">
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
                        <input type="text" class="form-control" id="placa{{ $control->id }}" onkeyup="this.value=this.value.toUpperCase()"
                            onchange="editInfoHistory('1', '{{ $control->id }}')" value="{{ $control->placa }}">
                    </div>
                </td>
            </tr>
            <tr style="width: 100%">
                <td style="width: 50%">
                    <div class="input-group mb-3 mr-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">SALVO CONDUCTO</span>
                        </div>
                        <input type="text" class="form-control" id="conducto{{ $control->id }}" onkeyup="this.value=this.value.toUpperCase()"
                            onchange="editInfoHistory('1', '{{ $control->id }}')" value="{{ $control->conducto }}">
                    </div>
                </td>
                <td style="width: 50%">
                    <div class="input-group mb-3 ml-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">CANTIDAD DE BLOQUES</span>
                        </div>
                        <input type="text" class="form-control" readonly value="{{ $control->total_bloques }}">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th rowspan="3" class="text-center" style="vertical-align: middle">Re-imprimir</th>
                <th rowspan="3" class="text-center" style="vertical-align: middle">CONSECUTIVO</th>
                <th colspan="4" class="text-center">PUNTA</th>
            </tr>
            <tr>
                <th colspan="3" class="text-center">MEDIDAS</th>
                <th rowspan="2" class="text-center" style="vertical-align: middle"> CANTIDAD PULGADA</th>
            </tr>
            <tr>
                <th class="text-center">ANCHO (cm)</th>
                <th class="text-center">GRUESO (cm)</th>
                <th class="text-center">LARGO (m)</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($madera as $item)
                <tr>
                    <td><button type="button" onclick="reImprimirCodigoQRPrinter('{{ $item->id }}','2')" class="btn btn-danger"><i
                                class="fa fa-print"></i></button></td>
                    <td class="text-center">{{ $item->id }}</td>
                    <td>
                        <input type="number" id="ancho{{ $item->id }}" class="form-control"
                            onchange="editInfoHistory('2', '{{ $item->id }}')" value="{{ $item->ancho }}">
                    </td>
                    <td>
                        <input type="number" id="grueso{{ $item->id }}" class="form-control"
                            onchange="editInfoHistory('2', '{{ $item->id }}')" value="{{ $item->grueso }}">
                    </td>
                    <td>
                        <input type="number" id="largo{{ $item->id }}" class="form-control"
                            onchange="editInfoHistory('2', '{{ $item->id }}')" value="{{ $item->largo }}">
                    </td>
                    <td class="text-center" id="pulgadas{{ $item->id }}">{{ number_format($item->pulgadas) }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
