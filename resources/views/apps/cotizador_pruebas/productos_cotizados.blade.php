@extends('apps.cotizador_pruebas.plantilla.app')
@section('title')
    Liquidador
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
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
                                <a href="{{ route('lista.precios') }}" type="button" class="btn btn-sm btn-danger">Lista de precios</a>
                                {{-- <button type="button" class="btn btn-sm btn-success" id="btn-activar-dsto-add"
                                    onclick="habilitarCampoDstoAdd();">Descuento adicional</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center" id="detallesVistasCot">
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

            <div class="modal fade" id="modalGenerarCotizacion" tabindex="-1" aria-labelledby="modalGenerarCotizacionLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalGenerarCotizacionLabel">Generar cotización</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="formDatosCotizacionContado" class="was-validated" style="font-size: 14px" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="">Cédula</label>
                                        <input type="number" value="{{ isset($cliente->cedula_cliente) ? $cliente->cedula_cliente : '' }}"
                                            class="form-control" name="cedula_cliente" id="cedula_cliente" required>
                                        <div class="form-group form-check" id="div_check_sin_cedula">
                                            <input type="checkbox" class="form-check-input" id="check_sin_cedula">
                                            <label class="form-check-label" for="check_sin_cedula">Sin cédula</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Nombre</label>
                                        <input type="text" value="{{ isset($cliente->nombre_1) ? $cliente->nombre_1 : '' }}"
                                            onkeyup="this.value=this.value.toUpperCase()" class="form-control" name="primer_nombre" id="primer_nombre"
                                            required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Apellidos</label>
                                        <input type="text" value="{{ isset($cliente->apellido_1) ? $cliente->apellido_1 : '' }}"
                                            onkeyup="this.value=this.value.toUpperCase()" class="form-control" name="primer_apellido"
                                            id="primer_apellido">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Departamento</label>
                                        <select name="depto" id="depto" onchange="obtenerCiudadesCoti(this.value)" class="form-control" required>
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
                                        <input type="text" value="{{ isset($cliente->barrio) ? $cliente->barrio : '' }}" class="form-control"
                                            name="barrio" id="barrio">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Dirección</label>
                                        <input type="text" value="{{ isset($cliente->direccion) ? $cliente->direccion : '' }}" class="form-control"
                                            name="direccion" id="direccion">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Teléfono 1</label>
                                        <input type="text" value="{{ isset($cliente->celular_1) ? $cliente->celular_1 : '' }}" class="form-control"
                                            minlength="7" maxlength="10" pattern="\d{7,10}" name="telefono1" id="telefono1" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">E-mail</label>
                                        <input type="email" value="{{ isset($cliente->email) ? $cliente->email : '' }}" class="form-control"
                                            name="correo" id="correo">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Género</label>
                                        <select name="genero" id="genero" class="form-control" required>
                                            <option value="">Seleccionar...</option>
                                            <option value="HOMBRE"
                                                {{ isset($cliente->genero) ? ($cliente->genero == 'HOMBRE' ? 'selected' : '') : '' }}>HOMBRE
                                            </option>
                                            <option value="MUJER" {{ isset($cliente->genero) ? ($cliente->genero == 'MUJER' ? 'selected' : '') : '' }}>
                                                MUJER
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Fecha cumpleaños</label>
                                        <input type="date" value="{{ isset($cliente->fecha_cumple) ? $cliente->fecha_cumple : '' }}"
                                            class="form-control" name="cumple_cl" id="cumple_cl">
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
                                                <div style="cursor: pointer" onclick="generarInformacionCotizacion('pdf')">
                                                    <i class="far fa-file-pdf" style="font-size: 35px; color:rgb(197, 197, 197)"></i>
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
                                                    <i class="fab fa-whatsapp" style="font-size: 35px; color:rgb(197, 197, 197)"></i>
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
                                                <div style="cursor: pointer" onclick="generarInformacionCotizacion('email')">
                                                    <i class="far fa-envelope" style="font-size: 35px; color:rgb(197, 197, 197)"></i>
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

            <div class="modal fade" id="modalInfoSolicitarCredito" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Solicitar crédito</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="formulario-datos-cliente-cotizacion" class="was-validated" style="font-size: 14px" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="">Cédula</label>
                                        <input type="text" onchange="validarInformacionIngresadaCred()" class="form-control" pattern="\d{7,10}"
                                            name="cedula_credito" id="cedula_credito" minlength="7" maxlength="10" required>
                                        <div class="invalid-feedback">
                                            La cédula debe tener entre 7 y 10 dígitos.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Primer Nombre</label>
                                        <input type="text" value="{{ isset($cliente->nombre_1) ? $cliente->nombre_1 : '' }}" class="form-control"
                                            name="nombre1_credito" id="nombre1_credito" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Segundo Nombre</label>
                                        <input type="text" value="{{ isset($cliente->nombre_2) ? $cliente->nombre_2 : '' }}" class="form-control"
                                            name="nombre2_credito" id="nombre2_credito">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Primer Apellido</label>
                                        <input type="text" value="{{ isset($cliente->apellido_1) ? $cliente->apellido_1 : '' }}"
                                            class="form-control" name="apellido1_credito" id="apellido1_credito" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Segundo Apellido</label>
                                        <input type="text" value="{{ isset($cliente->apellido_2) ? $cliente->apellido_2 : '' }}"
                                            class="form-control" name="apellido2_credito" id="apellido2_credito">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Departamento</label>
                                        <select name="depto_credito" id="depto_credito" onchange="obtenerCiudadesCotiCredito(this.value)"
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
                                        <select name="ciudad_credito" id="ciudad_credito" class="form-control" required>
                                            <option value="">Seleccionar...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Barrio</label>
                                        <input type="text" value="{{ isset($cliente->barrio) ? $cliente->barrio : '' }}" class="form-control"
                                            name="barrio_credito" id="barrio_credito" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Dirección</label>
                                        <input type="text" value="{{ isset($cliente->direccion) ? $cliente->direccion : '' }}" class="form-control"
                                            name="direccion_credito" id="direccion_credito" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Teléfono 1</label>
                                        <input type="text" value="{{ isset($cliente->celular_1) ? $cliente->celular_1 : '' }}" class="form-control"
                                            minlength="7" maxlength="10" pattern="\d{7,10}" name="telefono1_credito" id="telefono1_credito"
                                            required>
                                        <div class="invalid-feedback">
                                            El número debe tener entre 7 y 10 dígitos.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">Teléfono 2</label>
                                        <input type="text" value="{{ isset($cliente->celular_2) ? $cliente->celular_2 : '' }}" class="form-control"
                                            minlength="7" maxlength="10" pattern="\d{7,10}" name="telefono2_credito" id="telefono2_credito">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="">E-mail</label>
                                        <input type="email" value="{{ isset($cliente->email) ? $cliente->email : '' }}" class="form-control"
                                            name="correo_credito" id="correo_credito" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-danger" id="btnSolicitarCredito">Solicitar crédito</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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

    <div class="modal fade" id="modalInfoCuentasCartera" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body" id="info-cuentas-cartera-error"></div>
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
        obtenerCiudadesCoti = (id) => {
            if (id.length > 0) {
                $('#depto').removeClass('is-invalid')
                $('#depto').addClass('is-valid')

                var datos = $.ajax({
                    url: "{{ Route('ciudades.consultar') }}",
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
                    url: "{{ Route('ciudades.consultar') }}",
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

        $(document).ready(() => {
            StylesTableCotizacion();
        });

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
                url: "{{ route('eliminar.item.cot.pruebas') }}",
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
                url: "{{ route('actualizar.producto.pruebas') }}",
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
                    url: "{{ route('datos.cotizacion.pruebas') }}",
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
            var total_pagar = $("#total_a_pagar").val()
            var valor_pagar = parseFloat(total_pagar);
            var valor_financiar = parseFloat(valor);

            var formatter = new Intl.NumberFormat();

            if (valor.length > 0) {
                document.getElementById('txtValorFinanciar').hidden = false;
                document.getElementById('txtValorRestaCredito').hidden = false;
                var valor_resta = valor_pagar - valor_financiar;
                $("#valor_nuevo_financiar").val(formatter.format(valor_financiar));
                $("#valor_resta_financiar").val(formatter.format(valor_resta));
            } else {
                document.getElementById('txtValorFinanciar').hidden = true;
                document.getElementById('txtValorRestaCredito').hidden = true;
                $("#valor_nuevo_financiar").val("");
                $("#valor_resta_financiar").val("");
            }
        }

        validarCampos = () => {
            var cedula = $("#cedula_cliente").val()
            var nombre = $("#primer_nombre").val()
            var dpto = $("#depto").val()
            var ciudad = $("#ciudad").val()
            var celular = $("#telefono1").val()
            var genero = $("#genero").val()
            if (cedula.length > 0 && nombre.length > 0 && dpto.length > 0 && ciudad.length > 0 && celular.length > 0 && genero.length > 0) {
                return true
            }
            return false
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
