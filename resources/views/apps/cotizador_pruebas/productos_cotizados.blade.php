@extends('apps.cotizador_pruebas.plantilla.app')
@section('title')
    Liquidador
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <style>
        .swal2-toast {
            max-width: 100% !important;
        }

        .custom-btn-outline-danger {
            color: #5f01cb;
            border-color: #5f01cb;
        }

        .custom-btn-outline-danger:hover {
            color: #fff;
            background-color: #5f01cb;
            border-color: #5f01cb;
        }

        .custom-btn-outline-danger:focus,
        .custom-btn-outline-danger.focus {
            box-shadow: 0 0 0 0.2rem rgba(95, 1, 203, 0.5);
        }

        .custom-btn-outline-danger:active,
        .custom-btn-outline-danger.active,
        .custom-btn-outline-danger.dropdown-toggle.show {
            color: #fff;
            background-color: #5f01cb;
            border-color: #5f01cb;
        }

        .custom-btn-outline-danger:active:focus,
        .custom-btn-outline-danger.active:focus {
            box-shadow: 0 0 0 0.2rem rgba(95, 1, 203, 0.5);
        }

        .custom-btn-danger {
            color: #fff;
            background-color: #5f01cb;
            border-color: #5f01cb;
        }

        .custom-btn-danger:hover {
            color: #fff;
            background-color: #4e009c;
            border-color: #4e009c;
        }

        .custom-btn-danger:focus,
        .custom-btn-danger.focus {
            box-shadow: 0 0 0 0.2rem rgba(95, 1, 203, 0.5);
        }

        .custom-btn-danger:active,
        .custom-btn-danger.active,
        .custom-btn-danger.dropdown-toggle.show {
            color: #fff;
            background-color: #4e009c;
            border-color: #4e009c;
        }

        .custom-btn-danger:active:focus,
        .custom-btn-danger.active:focus {
            box-shadow: 0 0 0 0.2rem rgba(95, 1, 203, 0.5);
        }

        .cu_couta_mensual{
            font-size: 0.4em;
            font-weight: bold;
        }
    </style>
@endsection
@section('body')
    <div class="panel-inicio" id="panel-prod-cotizados">
        @if (count($productos) > 0)
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            Liquidador final
                        </div>
                        <div class="card-body">
                            <div id="productsCotizadosAlbura"><?php echo $tblProducts; ?></div>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('lista.precios.crexit') }}" type="button"
                                    class="btn btn-sm btn-danger">Lista de precios</a>
                                {{-- <button type="button" class="btn btn-sm btn-success" id="btn-activar-dsto-add"
                                    onclick="habilitarCampoDstoAdd();">Descuento adicional</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="justify-content-center" id="detallesVistasCot">
                <?php echo $planesV; ?>
            </div>

            {{--             <div class="row mb-3">
                <div class="col-md-12 text-center">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-danger" onclick="ValidarPlaFinanciacion('CO')">Cotización general</button>
                        <button type="button" class="btn btn-success" onclick="ValidarPlaFinanciacion('CRE')">Solicitar crédito</button>
                    </div>
                </div>
            </div> --}}

            <div class="modal fade" id="modalGenerarCotizacion" tabindex="-1" aria-labelledby="modalGenerarCotizacionLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalGenerarCotizacionLabel">Generar cotización</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="formDatosCotizacionContado" class="was-validated" style="font-size: 14px"
                                autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="">Cédula</label>
                                        <input type="number"
                                            value="{{ isset($cliente->cedula_cliente) ? $cliente->cedula_cliente : '' }}"
                                            class="form-control" name="cedula_cliente" id="cedula_cliente" required>
                                        <div class="form-group form-check" id="div_check_sin_cedula">
                                            <input type="checkbox" class="form-check-input" id="check_sin_cedula">
                                            <label class="form-check-label" for="check_sin_cedula">Sin cédula</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Nombre</label>
                                        <input type="text"
                                            value="{{ isset($cliente->nombre_1) ? $cliente->nombre_1 : '' }}"
                                            onkeyup="this.value=this.value.toUpperCase()" class="form-control"
                                            name="primer_nombre" id="primer_nombre" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Apellidos</label>
                                        <input type="text"
                                            value="{{ isset($cliente->apellido_1) ? $cliente->apellido_1 : '' }}"
                                            onkeyup="this.value=this.value.toUpperCase()" class="form-control"
                                            name="primer_apellido" id="primer_apellido">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Departamento</label>
                                        <select name="depto" id="depto" onchange="obtenerCiudadesCoti(this.value)"
                                            class="form-control" required>
                                            <option value="">Seleccionar</option>
                                            @foreach ($dptos as $item)
                                                <option value="{{ $item->id_depto }}"
                                                    {{ isset($cliente->id_depto) ? ($cliente->id_depto == $item->id_depto ? 'selected' : '') : '' }}>
                                                    {{ $item->depto }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Ciudad</label>
                                        <select name="ciudad" id="ciudad" class="form-control" required>
                                            <option value="">Seleccionar...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Barrio</label>
                                        <input type="text" value="{{ isset($cliente->barrio) ? $cliente->barrio : '' }}"
                                            class="form-control" name="barrio" id="barrio">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Dirección</label>
                                        <input type="text"
                                            value="{{ isset($cliente->direccion) ? $cliente->direccion : '' }}"
                                            class="form-control" name="direccion" id="direccion">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Teléfono 1</label>
                                        <input type="text"
                                            value="{{ isset($cliente->celular_1) ? $cliente->celular_1 : '' }}"
                                            class="form-control" minlength="7" maxlength="10" pattern="\d{7,10}"
                                            name="telefono1" id="telefono1" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">E-mail</label>
                                        <input type="email" value="{{ isset($cliente->email) ? $cliente->email : '' }}"
                                            class="form-control" name="correo" id="correo">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Género</label>
                                        <select name="genero" id="genero" class="form-control" required>
                                            <option value="">Seleccionar...</option>
                                            <option value="HOMBRE"
                                                {{ isset($cliente->genero) ? ($cliente->genero == 'HOMBRE' ? 'selected' : '') : '' }}>
                                                HOMBRE
                                            </option>
                                            <option value="MUJER"
                                                {{ isset($cliente->genero) ? ($cliente->genero == 'MUJER' ? 'selected' : '') : '' }}>
                                                MUJER
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="mes_dia">Fecha cumpleaños (Mes - Día)</label>
                                        <div class="d-flex">
                                            <select class="form-control mr-2" name="mes_cumple" id="mes_cumple" required>
                                                <option value="" selected disabled>Seleccionar</option>
                                                <option value="01">Enero</option>
                                                <option value="02">Febrero</option>
                                                <option value="03">Marzo</option>
                                                <option value="04">Abril</option>
                                                <option value="05">Mayo</option>
                                                <option value="06">Junio</option>
                                                <option value="07">Julio</option>
                                                <option value="08">Agosto</option>
                                                <option value="09">Septiembre</option>
                                                <option value="10">Octubre</option>
                                                <option value="11">Noviembre</option>
                                                <option value="12">Diciembre</option>
                                            </select>

                                            <select class="form-control" name="dia_cumple" id="dia_cumple" required>
                                                <option value="" selected disabled>Seleccionar</option>
                                                @for ($i = 1; $i <= 31; $i++)
                                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                                        {{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="">Observaciones</label>
                                        <textarea name="observaciones" id="observaciones" class="form-control" cols="30" rows="1">{{ session('observaciones') }}</textarea>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-2">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div style="cursor: pointer"
                                                    onclick="generarInformacionCotizacion('pdf')">
                                                    <i class="far fa-file-pdf text-danger" style="font-size: 35px"></i>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                Generar PDF
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card text-center">
                                            <div class="card-body text-center">
                                                <div style="cursor: pointer" onclick="generarInformacionCotizacion('wp')">
                                                    <i class="fab fa-whatsapp text-success" style="font-size: 35px"></i>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                Enviar por WhatsApp
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card text-center">
                                            <div class="card-body text-center">
                                                <div style="cursor: pointer"
                                                    onclick="generarInformacionCotizacion('email')">
                                                    <i class="far fa-envelope text-info" style="font-size: 35px"></i>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                Enviar por email
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalInfoSolicitarCredito" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#5f01cb;">
                            <h5 class="modal-title text-white" id="exampleModalLabel">Solicitar crédito</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="formInformacionClienteNuevoCredito" class="was-validated" style="font-size: 14px"
                                autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="">Cédula</label>
                                        <input type="text" onchange="validarInformacionIngresadaCred()"
                                            class="form-control" pattern="\d{7,10}" name="cedula_credito"
                                            id="cedula_credito" minlength="7" maxlength="10" required>
                                        <div class="invalid-feedback">
                                            La cédula debe tener entre 7 y 10 dígitos.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Primer Nombre</label>
                                        <input type="text" onkeyup="this.value=this.value.toUpperCase()"
                                            value="{{ isset($cliente->nombre_1) ? $cliente->nombre_1 : '' }}"
                                            class="form-control" name="nombre1_credito" id="nombre1_credito" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Segundo Nombre</label>
                                        <input type="text" onkeyup="this.value=this.value.toUpperCase()"
                                            value="{{ isset($cliente->nombre_2) ? $cliente->nombre_2 : '' }}"
                                            class="form-control" name="nombre2_credito" id="nombre2_credito">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Primer Apellido</label>
                                        <input type="text" onkeyup="this.value=this.value.toUpperCase()"
                                            value="{{ isset($cliente->apellido_1) ? $cliente->apellido_1 : '' }}"
                                            class="form-control" name="apellido1_credito" id="apellido1_credito"
                                            required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Segundo Apellido</label>
                                        <input type="text" onkeyup="this.value=this.value.toUpperCase()"
                                            value="{{ isset($cliente->apellido_2) ? $cliente->apellido_2 : '' }}"
                                            class="form-control" name="apellido2_credito" id="apellido2_credito">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Departamento</label>
                                        <select name="depto_credito" id="depto_credito"
                                            onchange="obtenerCiudadesCotiCredito(this.value)" class="form-control"
                                            required>
                                            <option value="">Seleccionar</option>
                                            @foreach ($dptos as $item)
                                                <option value="{{ $item->id_depto }}"
                                                    {{ isset($cliente->id_depto) ? ($cliente->id_depto == $item->id_depto ? 'selected' : '') : '' }}>
                                                    {{ $item->depto }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Ciudad</label>
                                        <select name="ciudad_credito" id="ciudad_credito" class="form-control" required>
                                            <option value="">Seleccionar...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Barrio</label>
                                        <input type="text" onkeyup="this.value=this.value.toUpperCase()"
                                            value="{{ isset($cliente->barrio) ? $cliente->barrio : '' }}"
                                            class="form-control" name="barrio_credito" id="barrio_credito" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Dirección</label>
                                        <input type="text" onkeyup="this.value=this.value.toUpperCase()"
                                            value="{{ isset($cliente->direccion) ? $cliente->direccion : '' }}"
                                            class="form-control" name="direccion_credito" id="direccion_credito"
                                            required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Teléfono 1</label>
                                        <input type="text"
                                            value="{{ isset($cliente->celular_1) ? $cliente->celular_1 : '' }}"
                                            class="form-control" minlength="7" maxlength="10" pattern="\d{7,10}"
                                            name="telefono1_credito" id="telefono1_credito" required>
                                        <div class="invalid-feedback">
                                            El número debe tener entre 7 y 10 dígitos.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Teléfono 2</label>
                                        <input type="text"
                                            value="{{ isset($cliente->celular_2) ? $cliente->celular_2 : '' }}"
                                            class="form-control" minlength="7" maxlength="10" pattern="\d{7,10}"
                                            name="telefono2_credito" id="telefono2_credito">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">E-mail</label>
                                        <input type="email" onkeyup="this.value=this.value.toLowerCase()"
                                            value="{{ isset($cliente->email) ? $cliente->email : '' }}"
                                            class="form-control" name="correo_credito" id="correo_credito" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Género</label>
                                        <select name="genero_credito" id="genero_credito" class="form-control" required>
                                            <option value="">Seleccionar...</option>
                                            <option value="HOMBRE"
                                                {{ isset($cliente->genero) ? ($cliente->genero == 'HOMBRE' ? 'selected' : '') : '' }}>
                                                HOMBRE
                                            </option>
                                            <option value="MUJER"
                                                {{ isset($cliente->genero) ? ($cliente->genero == 'MUJER' ? 'selected' : '') : '' }}>
                                                MUJER
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="mes_dia">Fecha cumpleaños (Mes - Día)</label>
                                        <div class="d-flex">
                                            <select class="form-control mr-2" name="mes_cumple_credito_" id="mes_cumple_credito_" required>
                                                <option value="" selected disabled>Seleccionar</option>
                                                <option value="01">Enero</option>
                                                <option value="02">Febrero</option>
                                                <option value="03">Marzo</option>
                                                <option value="04">Abril</option>
                                                <option value="05">Mayo</option>
                                                <option value="06">Junio</option>
                                                <option value="07">Julio</option>
                                                <option value="08">Agosto</option>
                                                <option value="09">Septiembre</option>
                                                <option value="10">Octubre</option>
                                                <option value="11">Noviembre</option>
                                                <option value="12">Diciembre</option>
                                            </select>

                                            <select class="form-control" name="dia_cumple_credito_" id="dia_cumple_credito_" required>
                                                <option value="" selected disabled>Seleccionar</option>
                                                @for ($i = 1; $i <= 31; $i++)
                                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                                        {{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="">Observaciones</label>
                                        <textarea name="observaciones_credito_" id="observaciones_credito_" class="form-control" cols="30" rows="1">{{ session('observaciones') }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Valor a financiar</span>
                                            </div>
                                            <input type="text" name="txt_financiar_credito" id="txt_financiar_credito"
                                                readonly class="form-control">
                                            <input type="text" name="txt_financiar_credito_inicial" hidden
                                                id="txt_financiar_credito_inicial" readonly class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button hidden type="button" class="btn custom-btn-danger" id="btnSolicitarCredito"
                                onclick="solicitarCreditoCoitzador()">Solicitar
                                crédito</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalValorFinanciarCredito" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #5f01cb">
                            <h5 class="modal-title" style="color: #fff" id="exampleModalLabel">Valor a financiar</h5>
                            <button style="color: #fff" type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="">Valor neto</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon3">$</span>
                                        </div>
                                        <input type="number" class="form-control" name="vlr_financiar_credito"
                                            id="vlr_financiar_credito">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="">Cuota inicial</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon3">$</span>
                                        </div>
                                        <input type="text" class="form-control"
                                            onkeyup="calcularValorCredito(this.value)" name="valor_a_financiar"
                                            id="valor_a_financiar">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3" id="txtValorFinanciar" hidden>
                                    <label for="">Valor a financiar</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon3">$</span>
                                        </div>
                                        <input type="text" class="form-control" name="valor_nuevo_financiar"
                                            id="valor_nuevo_financiar" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3" id="txtValorRestaCredito" hidden>
                                    <label for="">Valor cuota inicial</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon3">$</span>
                                        </div>
                                        <input type="text" class="form-control" name="valor_resta_financiar"
                                            id="valor_resta_financiar" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="">¿A cuantos meses?</label>
                                    <select name="cuotas_credito_simulador" id="cuotas_credito_simulador"
                                        class="form-control" required>
                                        <option value="NAN" selected disabled>Seleccione número de cuotas</option>
                                        <option value="3">3</option>
                                        <option value="6">6</option>
                                        <option value="12">12</option>
                                        <option value="18">18</option>
                                        <option value="24">24</option>
                                        <option value="30">30</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-around">
                            <button type="button" class="btn custom-btn-outline-danger"
                                onclick="calcularValorCredito_simulador()">Simular Credito</button>
                            <button type="button" class="btn custom-btn-danger"
                                onclick="formSolicitarEstudioDeCredito()">Generar el estudio de
                                crédito</button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="mensaje text-center mt-5">
                <img src="{{ asset('img/triste.png') }}" width="12%" alt="">
                <h4>UPS !! No tienes productos cotizados</h4>
            </div>
        @endif
    </div>

    <div class="modal fade" id="modalInfoCuentasCartera" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body" id="info-cuentas-cartera-error"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar información</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_simulador_creditos_albura" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Simulador de credito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="información_simulador_creditos"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar información</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('footer')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(() => {
            StylesTableCotizacion();
            var format = new Intl.NumberFormat();
            $("#txt_financiar_credito").val("$ " + format.format($("#total_a_pagar").val()))
            $("#txt_financiar_credito_inicial").val("$ " + format.format($("#valor_resta_financiar").val()));
        });

        obtenerCiudadesCoti = (id) => {
            if (id.length > 0) {
                $('#depto').removeClass('is-invalid')
                $('#depto').addClass('is-valid')

                var datos = $.ajax({
                    url: "{{ Route('ciudades.consultar.crexit') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                datos.done((res) => {
                    if (res.status == true) {
                        $('#ciudad').html(res.ciudad);
                    }
                });
            } else {
                $('#depto').removeClass('is-valid')
                $('#depto').addClass('is-invalid')
            }
        }

        obtenerCiudadesCotiCredito = (id) => {
            if (id.length > 0) {
                var datos = $.ajax({
                    url: "{{ Route('ciudades.consultar.crexit') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                datos.done((res) => {
                    if (res.status == true) {
                        $('#ciudad_credito').html(res.ciudad);
                    }
                });
            }
        }
        StylesTableCotizacion = () => {
            $("#productos-liquidador-albura").DataTable({
                oLanguage: {
                    sSearch: "Buscar:",
                    sInfo: "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                    oPaginate: {
                        sPrevious: "Volver",
                        sNext: "Siguiente",
                    },
                    sEmptyTable: "No se encontró ningun registro en la base de datos",
                    sZeroRecords: "No se encontraron resultados...",
                    sLengthMenu: "Mostrar _MENU_ registros",
                },
                order: [
                    [0, "asc"]
                ],
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: true,
                responsive: true,
            });
        };

        var check = document.getElementById("check_sin_cedula");
        check.addEventListener("change", function() {
            var numeroced = Math.floor(Math.random() * 1000000000) + 1000000;
            if (this.checked) {
                $("#cedula_cliente").val(numeroced);
            } else {
                $("#cedula_cliente").val("");
            }
        });

        habilitarCampoDstoAdd = () => {
            if ($(".vlr_add_class").is(":disabled")) {
                $("#btn-activar-dsto-add").removeClass("btn btn-success");
                $("#btn-activar-dsto-add").addClass("btn btn-warning");
                $(".vlr_add_class").prop("disabled", false);
            } else {
                $("#btn-activar-dsto-add").removeClass("btn btn-warning");
                $("#btn-activar-dsto-add").addClass("btn btn-success");
                $(".vlr_add_class").prop("disabled", true);
            }
        };

        FormatearCamposFormulario = () => {
            document.getElementById("formularioDatosCliente").hidden = true;

            $(".form-cmp").removeClass("is-invalid");
            $(".form-cmp").removeClass("is-valid");
            $(".form-cmp").addClass("is-valid");
            $("#tipo_cotizacion").val("");
        };

        ValidarCamposRequeridos = (tipo_cotizacion) => {
            FormatearCamposFormulario();

            setTimeout(() => {
                document.getElementById("formularioDatosCliente").hidden = false;
            }, 500);

            switch (tipo_cotizacion) {
                case "CO":
                    document.getElementById("text-form").innerHTML = "Cotización";
                    document.getElementById("div_check_sin_cedula").hidden = false;
                    $("#tipo_cotizacion").val("CO");

                    $("#cedula_cliente").addClass("is-invalid");
                    $("#primer_nombre").addClass("is-invalid");
                    $("#ciudad").addClass("is-invalid");
                    $("#telefono1").addClass("is-invalid");
                    $("#genero").addClass("is-invalid");
                    $("#categoria").addClass("is-invalid");
                    $("#observaciones").addClass("is-invalid");
                    break;
                case "CRE":
                    document.getElementById("text-form").innerHTML = "OnCredit";
                    document.getElementById("div_check_sin_cedula").hidden = true;
                    $("#tipo_cotizacion").val("CRE");

                    $("#cedula_cliente").addClass("is-invalid");
                    $("#primer_nombre").addClass("is-invalid");
                    $("#primer_apellido").addClass("is-invalid");
                    $("#direccion").addClass("is-invalid");
                    $("#ciudad").addClass("is-invalid");
                    $("#barrio").addClass("is-invalid");
                    $("#telefono1").addClass("is-invalid");
                    $("#correo").addClass("is-invalid");
                    $("#genero").addClass("is-invalid");
                    $("#categoria").addClass("is-invalid");
                    break;
            }
        };


        NotificarActualizandoInfo = () => {
            Swal.fire({
                position: "top-end",
                icon: "info",
                title: "Actualizando Información...",
                showConfirmButton: false,
                timer: 2000,
            });
        };

        EliminarProductoCotizado = (id_cotizacion) => {
            Swal.fire({
                title: "Estas seguro de eliminar?",
                text: "No podrás reversar la operación",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar",
                cancelButtonText: "No, cancelar!",
            }).then((result) => {
                if (result.isConfirmed) {

                    loandingPanel()

                    var datos = ConfirmEliminarProducto(id_cotizacion);

                    datos.done((res) => {

                        loadedPanel()

                        if (res.status == true) {
                            document.getElementById(
                                "productsCotizadosAlbura"
                            ).innerHTML = res.tblProducts;
                            document.getElementById("detallesVistasCot").innerHTML =
                                res.viewDetalle;

                            StylesTableCotizacion();
                        }
                    });
                    datos.fail(() => {

                        loadedPanel()

                        Swal.fire(
                            "ERROR!",
                            "Hubo un problema al procesar la solicitud",
                            "error"
                        );
                    });
                }
            });
        };

        ConfirmEliminarProducto = (id_cotizacion, url) => {
            var datos = $.ajax({
                url: "{{ route('eliminar.item.cot.crexit') }}",
                type: "POST",
                dataType: "json",
                data: {
                    id_cotizacion,
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            return datos;
        };

        ActualizarProductoCotizado = (id_cotizacion) => {

            loandingPanel()

            var cantidad = $("#cantidad" + id_cotizacion).val();
            var descuento = $("#descuento" + id_cotizacion).val();
            var dsto_ad = $("#dsto_ad" + id_cotizacion).val();

            var datos = $.ajax({
                url: "{{ route('actualizar.producto.crexit') }}",
                type: "POST",
                dataType: "json",
                data: {
                    id_cotizacion,
                    cantidad,
                    descuento,
                    dsto_ad,
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            datos.done((res) => {

                loadedPanel()

                if (res.status == true) {
                    document.getElementById("productsCotizadosAlbura").innerHTML =
                        res.tblProducts;
                    document.getElementById("detallesVistasCot").innerHTML =
                        res.viewDetalle;

                    StylesTableCotizacion();
                }
            });
            datos.fail(() => {

                loadedPanel()

                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "No se encontraron cambios por realizar",
                    showConfirmButton: false,
                    timer: 2000,
                });
            });
        };

        generarInformacionCotizacion = (seccion) => {
            var validar = false;
            var mensaje = "";
            switch (seccion) {
                case 'pdf':
                    validar = validarCampos()

                    break;
                case 'wp':
                    validar = validarCampos()

                    break;
                case 'email':
                    validar = validarCampos()
                    var email = $("#correo").val()
                    if (email.length > 0 && validar) {
                        validar = true
                    } else {
                        validar = false
                        mensaje = "Revisa la información del email, no puede estar vacio"
                    }

                    break;
            }
            if (validar) {

                Swal.fire({
                    position: "top-end",
                    icon: "info",
                    title: "Estamos validando la información, por favor espera...",
                    showConfirmButton: false,
                    timer: 5000,
                    toast: true
                });
                var ciudad = $("#ciudad").find("option:selected");
                var depto = document.getElementById("depto");
                var nom_depto = depto.options[depto.selectedIndex].text;

                var formData = new FormData(document.getElementById("formDatosCotizacionContado"));
                formData.append("opcion_final", seccion);
                formData.append("id_ciudad", ciudad.data("id_city"));
                formData.append("departamento", nom_depto);
                formData.append("cumple_cl", `2024-${$('#mes_cumple').val()}-${$('#dia_cumple').val()}`);

                var datos = $.ajax({
                    url: "{{ route('agregar.crm.cotizacion') }}",
                    type: "POST",
                    dataType: "json",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                });
                datos.done((res) => {
                    if (res.status == true) {
                        if (seccion == "email") {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "¡EXCELENTE! La información se ha enviado al correo exitosamente",
                                showConfirmButton: false,
                                timer: 5000,
                                toast: true
                            });
                        } else {
                            window.open(res.url, '_BLANK');
                        }
                    }
                })
                datos.fail(() => {

                })

            } else {
                var mensaje_ = mensaje.length > 0 ? mensaje : "Revisa la información en rojo"
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: mensaje_,
                    showConfirmButton: false,
                    timer: 4000,
                });
            }

        }



        validarInformacionIngresadaCred = () => {
            var cedula = $("#cedula_credito").val()

            if (cedula.length > 0) {
                var datos = $.ajax({
                    url: "{{ route('datos.cotizacion.crexit') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        cedula
                    }
                });
                datos.done((res) => {
                    if (res.status == "cartera") {
                        document.getElementById('btnSolicitarCredito').hidden = true;
                        $("#modalInfoCuentasCartera").modal("show");

                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: res.mensaje,
                            showConfirmButton: false,
                            timer: 10000,
                            toast: true,
                        });

                        document.getElementById("info-cuentas-cartera-error").innerHTML = res.table;
                    } else {
                        document.getElementById('btnSolicitarCredito').hidden = false;
                    }
                });
            }
        };

        calcularValorCredito = (valor) => {
            var valor_i = valor
            valor_i = valor_i.replace(/\./g, '');
            valor = valor_i

            var total_pagar = $("#total_a_pagar").val()
            var valor_pagar = parseFloat(total_pagar);
            var valor_financiar = parseFloat(valor);

            var formatter = new Intl.NumberFormat();

            $("#valor_a_financiar").val(formatter.format(valor))

            if (valor.length > 0) {
                document.getElementById('txtValorFinanciar').hidden = false;
                document.getElementById('txtValorRestaCredito').hidden = false;
                var valor_resta = valor_pagar - valor_financiar;
                $("#valor_nuevo_financiar").val(formatter.format(valor_resta));
                $("#valor_resta_financiar").val(formatter.format(valor_financiar));
                $("#txt_financiar_credito").val("$ " + formatter.format(valor_resta))
                $("#txt_financiar_credito_inicial").val("$ " + formatter.format($("#valor_resta_financiar").val()));
            } else {
                document.getElementById('txtValorFinanciar').hidden = true;
                document.getElementById('txtValorRestaCredito').hidden = true;
                $("#valor_nuevo_financiar").val("");
                $("#valor_resta_financiar").val("");
                $("#txt_financiar_credito").val("$ " + formatter.format(total_pagar))
                $("#txt_financiar_credito_inicial").val("$ " + formatter.format($("#valor_resta_financiar").val()));
            }
        }

        validarCampos = () => {
            var cedula = $("#cedula_cliente").val()
            var nombre = $("#primer_nombre").val()
            var dpto = $("#depto").val()
            var ciudad = $("#ciudad").val()
            var celular = $("#telefono1").val()
            var genero = $("#genero").val()
            if (cedula.length > 0 && nombre.length > 0 && dpto.length > 0 && ciudad.length > 0 && celular.length > 0 &&
                genero.length > 0) {
                return true
            }
            return false
        }

        solicitarEstudioDeCredito = () => {
            var formatter = new Intl.NumberFormat();
            $("#vlr_financiar_credito").prop('type', "text")
            var total_pagar = $("#total_a_pagar").val()
            $("#vlr_financiar_credito").val(formatter.format(total_pagar))
            $("#vlr_financiar_credito").prop('readonly', true)
            $("#modalValorFinanciarCredito").modal("show")
        }

        simuladorCredito = () => {

            $('#modal_simulador_creditos_albura').modal('toggle');

            $.ajax({
                url: "{{ route('traer.simulador.credito.crexit') }}",
                type: "POST",
                data: {
                    "total_pagar": $("#total_a_pagar").val()
                },
                success: (data) => {
                    $('#información_simulador_creditos').html(data.viewSimulador);
                },
                error: (err) => {
                    console.error(err);
                }
            })

            // window.open('https://crexit.com.co', "", "width=380, height=480, top=50, left=50");
        }

        formSolicitarEstudioDeCredito = () => {
            Swal.fire({
                title: `Estas seguro del valor a financiar: ${traerValorAFinanciar()}?`,
                text: "No podrás reversar la operación",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#5f01cb",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, continuar",
                cancelButtonText: "No, cancelar!",
            }).then((result) => {
                if (result.isConfirmed) {
                    confirmValorFinanciar()
                }
            });
        }

        confirmValorFinanciar = () => {
            $("#modalValorFinanciarCredito").modal("hide")
            $("#modalInfoSolicitarCredito").modal("show")
            $("#txt_financiar_credito").val("$ " + traerValorAFinanciar())
            $("#txt_financiar_credito_inicial").val("$ " + $("#valor_resta_financiar").val());
        }

        traerValorAFinanciar = () => {
            var formatter = new Intl.NumberFormat();
            var total_pagar = $("#valor_nuevo_financiar").val()
            var valor_inicial = $("#vlr_financiar_credito").val()
            if (total_pagar.length > 0) {
                return total_pagar;
            } else {
                return valor_inicial;
            }
        }

        solicitarCreditoCoitzador = () => {
            Swal.fire({
                position: "top-end",
                icon: "info",
                title: "Realizando la solicitud de crédito...",
                showConfirmButton: false,
                timer: 10000,
                toast: true,
            });

            var ciudad = $("#ciudad_credito").find("option:selected");
            var depto = document.getElementById("depto_credito");
            var nom_depto = depto.options[depto.selectedIndex].text;

            var formData = new FormData(document.getElementById("formInformacionClienteNuevoCredito"));
            formData.append("id_ciudad_credito", ciudad.data("id_city"));
            formData.append("ciudad_credito_name", $("#ciudad_credito").val());
            formData.append("departamento", nom_depto);
            formData.append("cumple_cl_credito", `2024-${$('#mes_cumple_credito_').val()}-${$('#dia_cumple_credito_').val()}`);

            var datos = $.ajax({
                url: "{{ route('generar.solicitud.credito.crexit') }}",
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
            })
            datos.done((res) => {
                console.log(res);
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: " " + res.mensaje,
                    showConfirmButton: false,
                    timer: 5000,
                    toast: true,
                });
            })
            datos.fail((jqXHR) => {
                let errorMessage = "";
                if (jqXHR.responseJSON && jqXHR.responseJSON.mensaje) {
                    errorMessage = jqXHR.responseJSON.mensaje;
                }
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: " " + errorMessage,
                    showConfirmButton: false,
                    timer: 6000,
                    toast: true,
                });
            })
        }

        calcularValorCredito_simulador = () => {

            let valor_i = "";

            if ($('#valor_nuevo_financiar').val() != "") {
                valor_i = $('#valor_nuevo_financiar').val()
            } else {
                valor_i = $('#vlr_financiar_credito').val();
            }

            valor_i = valor_i.replace(/\./g, '');

            let tasa_interes = 2.1348;
            let tasa_fogade = 14.28;
            let tasa_iva = 19;
            let tasa_promedio_iva = 10.825;
            let valor_financiar = Math.round(valor_i);
            let plazo_coutas = $('#cuotas_credito_simulador').val();
            /* HACER VALIDACIÓN DEL VALOR A FINANCIAR Y LAS CUOTAS */

            if (plazo_coutas == null || plazo_coutas == NaN) {
                Swal.fire({
                    position: "top",
                    icon: "error",
                    title: " Para realizar la simulación debes: seleccionar un plazo de coutas! ",
                    showConfirmButton: false,
                    timer: 5000,
                    toast: true,
                });
                return;
            }

            var formatter = new Intl.NumberFormat();

            let divisor_intereses = parseFloat(+tasa_interes / 100);
            let divisor_fogade = parseFloat(+tasa_fogade / 100);
            let divisor_iva = parseFloat(+tasa_iva / 100);
            let divisor_iva_promedio = parseFloat(+tasa_promedio_iva / 100);
            let valor_fogade = Math.round(+(valor_financiar * divisor_fogade) + valor_financiar);

            let PxI = parseFloat((valor_fogade * divisor_intereses) + ((valor_fogade * divisor_intereses) *
                divisor_iva));
            let ImasUno = parseFloat(1 + divisor_intereses);
            let UnoMasEleveadoNegativoPeriodo = parseFloat(ImasUno ** parseFloat(-plazo_coutas));
            let UnoMenosUnoPotenciadoPeriodo = parseFloat(1 - UnoMasEleveadoNegativoPeriodo);
            let iva_promedio = Math.round(valor_fogade * divisor_intereses * divisor_iva_promedio);

            let coutaMensualFija = Math.round((divisor_intereses * valor_fogade) / UnoMenosUnoPotenciadoPeriodo) +
                iva_promedio;

            let total_credito_crexit_ = Math.round(coutaMensualFija * plazo_coutas);


            // console.log(coutaMensualFija);
            Swal.fire({
                html: `
                <div class="container text-center">
                    <div class="mx-auto py-3 px-5 d-flex flex-column justify-content-between" style="border-radius:12px;width:350px; height:650px; box-shadow: 0px 0px 20px 0px rgb(0,0,0,0.3)">
                        <h2 class="fw-bold m-0 p-0" style="color:#5f01cb;">Cuota Mensual</h2>
                        <h1 class="fw-bold m-0 p-0" style="color:#5f01cb;"><b class="m-0 p-0">$${formatter.format(Math.round(coutaMensualFija))} <small class='cu_couta_mensual'>c/u</small></b></h1>

                        <div class="d-flex justify-content-between my-3">
                            <div class="text-start px-2 flex-fill">
                                <div class="fw-bold fs-4 m-0"><b>Número Cuotas</b></div>
                                <span style="color:#5f01cb;"><b>${plazo_coutas}</b></span>
                            </div>
                            <div class="text-start px-2 flex-fill border-left">
                                <div class="fw-bold fs-4 m-0"><b>Tasa Mensual</b></div>
                                <span style="color:#5f01cb;"><b>${2.13}%</b></span>
                            </div>
                            <div class="text-start px-2 flex-fill border-left">
                                <div class="fw-bold fs-4 m-0"><b>Tasa Aval</b></div>
                                <span style="color:#5f01cb;"><b>${tasa_fogade}%</b></span>
                            </div>
                        </div>

                        <div class="fw-bold fs-3 m-0 p-0"><h2 class="m-0 p-0">Total Crédito</h2></div>
                        <h2 style="color:#5f01cb;">$${formatter.format(Math.round(total_credito_crexit_))}</h2>
                        <div class="d-flex justify-content-center">
                            <img src="https://crexit.com.co/wp-content/uploads/2024/05/LogoCrexit-e1717190280798.png" alt="" class="logo-img" srcset="">
                        </div>
                        <br>
                        <p class="text-muted mt-3" style="font-size:12px">*El valor de tu cuota es un aproximado y dependerá de tu fecha de compra.*</p>
                        <p class="text-muted mt-3" style="font-size:12px">*El IVA ya viene aplicado en la cuota mensual, al igual que en el total del credito.*</p>
                        <p class="text-muted mt-3" style="font-size:12px">*La cuota es un promedio del plan que elijas.*</p>
                    </div>
                </div>
                <style>
                    .my-confirm-button {
                        background-color: #5f01cb !important;
                    }
                    .logo-img {
                        width: 100px;  /* Ajusta el ancho según sea necesario */
                        height: auto;  /* Mantiene la proporción de la imagen */
                        margin-top: 20px;  /* Añade margen superior si es necesario */
                    }
                    .border-left {
                        border-left: 2.5px solid #000000 !important;
                        padding-left: 2px; /* Añade padding para evitar que el contenido se pegue al borde */
                    }
                </style>`,
                customClass: {
                    container: 'swal2-bootstrap-custom-container',
                    confirmButton: 'my-confirm-button'
                },
            });
        }

        function validate_cumple_data(element) {
            let input = this.value;
            // Validar que cumpla el patrón MM-DD
            if (/^\d{2}-\d{2}$/.test(input)) {
                let [mes, dia] = input.split('-');
                console.log(`Mes: ${mes}, Día: ${dia}`);
                // Aquí puedes realizar cualquier otra acción con el mes y el día
            } else {
                console.log('Formato incorrecto. Debe ser MM-DD.');
            }

        }
    </script>
    @if (isset($cliente->id_depto))
        <script>
            $(() => {
                obtenerCiudadesCoti('{{ $cliente->id_depto }}');
                obtenerCiudadesCotiCredito('{{ $cliente->id_depto }}');
                setTimeout(() => {
                    $("#ciudad").val('{{ $cliente->ciudad }}')
                    $("#ciudad_credito").val('{{ $cliente->ciudad }}')
                }, 500);
            });
        </script>
    @endif
@endsection
